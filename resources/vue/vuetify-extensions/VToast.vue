<template>
    <v-snackbar v-model="showing" v-bind="$attrs" multi-line>
        <span>
            <v-icon class="mr-2" :color="options.iconColor">{{options.icon}}</v-icon>
        </span>
        {{options.message}}
        <v-spacer/>
        <v-btn icon @click="showing = false">
            <v-icon>mdi mdi-close</v-icon>
        </v-btn>
    </v-snackbar>
</template>

<script>

export default {
    inheritAttrs: false,
    data(){
        return{
            showing: false,
            options: {}
        }
    },
    methods: {
        toast(value){
            if(this.showing){
                this.showing = false,
                setTimeout(() => {
                    this.showing = true;
                    this.options = value
                }, 400)
            }
            else{
                this.showing = true;
                this.options = value
            }
        }
    },
    created(){
        window.toast = this.toast
    }
}
</script>

