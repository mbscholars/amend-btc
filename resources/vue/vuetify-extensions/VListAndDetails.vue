<template>
    <v-container grid-list-xl v-if="loaded">
        <v-layout wrap row v-resize="onResize">
            <v-flex :class="{fixed : $vuetify.breakpoint.smAndUp}" class="pb-0" v-show="$vuetify.breakpoint.smAndUp || currentView == 'list'" ref="flex">
                <template>
                    <slot name="list-toolbar"/>
                </template>
                <v-sheet id="containerVList" :max-height="maxHeight">
                    <v-scroll-view ref="scrollView" :loader="loader" :refresh="refresh" @update:refresh="$emit('update:refresh', $event)" :rules="rules">
                        <template v-slot="{item, index}">
                            <v-sheet :class="`${item.selected? selectedClass : ''}`">
                                <slot name="list" :on="{click: () => select(item, index, true)}" :item="item" :index="index"/>
                            </v-sheet>
                        </template>
                        <template v-slot:empty-state>
                            <slot name="empty-state"/> 
                        </template>
                    </v-scroll-view>
                </v-sheet>
            </v-flex>
            <v-flex xs12 sm5 md4 v-show="$vuetify.breakpoint.smAndUp || currentView == 'list'" ref="helperFlex" class="pa-0"/>
            <v-flex xs12 sm7 md8 v-show="($vuetify.breakpoint.smAndUp || currentView == 'details') && selectedIndex != null">
                <v-toolbar dense flat v-if="$vuetify.breakpoint.xs || $scopedSlots['details:toolbar']">
                    <v-btn icon @click="showListView" v-if="$vuetify.breakpoint.xs">
                        <v-icon>mdi mdi-arrow-left-circle-outline</v-icon>
                    </v-btn>
                    <slot name="details:toolbar" :item="selectedItem" :index="selectedIndex"/>
                </v-toolbar>
                <v-sheet :max-height="maxHeight" ref="containerVDetails" id="containerVDetails">
                    <slot name="details" :item="selectedItem" :index="selectedIndex"/>
                </v-sheet>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import VScrollView from "@/vuetify-extensions/VScrollView"

export default {
    props:{
        loader: {
            type: [Function, Array],
            default: () => []
        },
        refresh: Boolean,
        rules: {
            type: Array,
            default: () => []
        },
        maxHeight: {
            type: [String, Number],
            default: "60vh"
        },
        selectedClass: {
            type: [Array, Object],
            default: () => ["primary--text"]
        },
    },
    components: {
        VScrollView
    },
    data(){
        return {
            currentView: "list",
            selectedIndex: 0,
            selectedItem: {},
            tweakedLoader: [],
            loaded: false
        }
    },
    methods: {
        tweakLoader(){
            if(this.loader.constructor == Function){
                return (page) => this.loader(page).then(data => {
                    if(data.items.length > 0 && this.initial){
                        this.select(this.$refs.scrollView.items[0], 0)
                        this.initial = false;
                    }
                    return data
                })
            }
            else{
                this.select(this.loader[0], 0)
                return this.loader
            }
        },
        onResize(){
            this.$refs.flex.style.width = `${this.$refs.helperFlex.clientWidth}px`
        },
        showListView(){
            this.currentView = "list"
            this.$emit('change-view', 'list')
        },
        showDetailsView(){
            this.currentView = "details"
            this.$emit('change-view', 'details')
        },
        select(item, index, changeView = false){
            this.selectedItem.selected = false
            this.selectedItem = {};
            window.setTimeout(() => this.selectedItem = item, 50)
            this.$vuetify.goTo(0)
            this.selectedIndex = index;
            if(changeView){
                this.showDetailsView()
            } 
            this.$emit('selected', {item, index})
            this.$emit('change-view', 'details')
            item.selected = true
        }
    },
    mounted(){
        this.tweakedLoader = this.tweakLoader()
        this.loaded = true
    },
    watch: {
        refresh(newValue){
            if(newValue){
                this.select(this.$refs.scrollView.items[0], 0)
                this.initial = true
                this.$refs.scrollView.content.scrollTop = 0;
                this.$vuetify.goTo(0)
            }
        },
        loaded(newValue){
            if(newValue){
                this.$nextTick().then(this.onResize)
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .fixed{
        position: fixed;
    }
    #containerVList, #containerVDetails{
        overflow-y: auto; 
        border-radius: 0
    }
    .item{
        cursor: pointer;
    }
</style>
