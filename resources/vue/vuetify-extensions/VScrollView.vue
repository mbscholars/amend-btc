<template>
    <div ref="container">
        <v-container fill-height align-center  v-if="filteredItems.length == 0 && !loading">
            <slot name="empty-state">
                <v-empty-state title="List Empty" icon="list"/>
            </slot>
        </v-container>
        <div ref="scrollView" v-else>
            <template v-if="filteredItems.length > 0">
                <slot  v-for="(item, index) in filteredItems.slice(0, itemIndex)" :item="item" :index="index"/>
            </template>
            <center>
                <slot name="load-more" :on="{click: () => loadItems(false)}" v-if="hasNextPage && itemIndex >= filteredItems.length && !loading">
                    <v-btn @click="loadItems(false)">Load More</v-btn>
                </slot>
                <v-progress-circular color="primary" indeterminate v-if="loading"/>
            </center>
        </div>
    </div>
</template>

<script>
import VEmptyState from "@/vuetify-extensions/VEmptyState";

export default {
    name: "VScrollView",
    props: {
        loader: {
            type: [Function, Array],
            default: () => []
        },
        refresh: Boolean,
        rules: {
            type: Array,
            default: () => []
        },
        numberOfItemsPerView: {
            type: Number,
            default: 10
        }
    },
    data(){
        return {
            items: [],
            page: 1,
            loading: false,
            content: null,
            hasNextPage: false,
            itemIndex: 0
        }
    },
    components: {
        VEmptyState
    },
    computed:{
        filteredItems(){
            return this.items.filter((item, index) => {
                var flag = true;
                for(var rule of this.rules){
                    flag = flag && (rule(item, index) === true)
                }
                return flag
            })
        }
    },
    methods: {
        loadMoreItems(event){
            var scrollHeight = event.target.scrollHeight, 
                clientHeight = event.target.clientHeight,
                scrollTop = event.target.scrollTop;
            if(scrollHeight <= clientHeight + scrollTop && this.itemIndex < this.items.length){
                this.itemIndex += this.numberOfItemsPerView
            }
        },
        loadItems(reload = false){
            this.loading = true
            this.content.removeEventListener("scroll", this.loadMoreItems)
            if(this.loader.constructor == [].constructor){
                this.loading = false;
                this.items = this.loader
                this.content.addEventListener("scroll", this.loadMoreItems)
                if(reload){
                    this.itemIndex = this.numberOfItemsPerView
                }
                return this.$nextTick()
            }
            return this.loader(this.page).then(data => {
                if(reload){
                    this.items = data.items
                }
                else{
                    this.items.push(...data.items)
                }
                this.page++;
                this.loading = false;
                this.hasNextPage = data.hasNextPage
                if(this.hasNextPage){
                    this.content.addEventListener("scroll", this.loadMoreItems)
                }
            }).catch(() => {
                this.loading = false
                this.$emit("update:refresh", false)
            })
        }
    },
    mounted(){
        this.itemIndex = this.numberOfItemsPerView
        this.content = this.$refs.container.parentElement
        this.loadItems()
    },
    beforeDestroy(){
        this.content.removeEventListener("scroll", this.loadMoreItems)
    },
    watch: {
        refresh(newValue){
            if(newValue){
                this.page = 1
                this.items = []
                this.loadItems(true).then(() => this.$emit("update:refresh", false))
                this.content.scrollTop = 0
            }
        }
    }
}
</script>