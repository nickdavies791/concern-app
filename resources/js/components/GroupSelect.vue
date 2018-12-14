<template lang="html">
    <div>
        <multiselect v-model="groups" :options="options" :multiple="true" :close-on-select="true"
        :clear-on-select="false" :preserve-search="true" placeholder="Select a group"
        label="name" track-by="id">
    </multiselect>
    <select name="groups[]" style="display:none;" multiple>
        <option v-for="group in groups" :value="group.id" selected="selected"></option>
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
        getGroups(){
            axios.get('/groups').then(response =>{
                response.data.forEach(group => {
                    this.options.push(group);
                });
            });
        }
    },
    data () {
        return {
            groups: [],
            options: []
        }
    },
    created(){
        this.getGroups();
    }
}
</script>
