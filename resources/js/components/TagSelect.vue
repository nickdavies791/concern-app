<template lang="html">
    <div>
        <multiselect :open-direction="bottom" v-model="tags" :options="options" :multiple="true" :close-on-select="true"
        :clear-on-select="false" :preserve-search="true" placeholder="Select a tag"
        label="name" track-by="id">
    </multiselect>
    <select name="tag[]" style="display:none;" multiple>
        <option v-for="tag in tags" :value="tag.id" selected="selected"></option>
    </select>
</div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    methods: {
        getTags(){
            axios.get('/tags').then(response =>{
                response.data.forEach(tag => {
                    this.options.push(tag);
                });
            });
        }
    },
    data () {
        return {
            tags: [],
            options: [],
            bottom: 'bottom'
        }
    },
    created(){
        this.getTags();
    }
}
</script>
