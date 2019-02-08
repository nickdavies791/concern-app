<template lang="html">
    <div>
        <multiselect :open-direction="bottom" v-model="students" :options="options" :multiple="true" :close-on-select="true"
        :clear-on-select="false" :preserve-search="true" placeholder="Select a student" :custom-label="customLabel" track-by="id">
        </multiselect>
        <select name="students[]" style="display:none;" multiple>
            <option v-for="student in students" :value="student.id" selected="selected"></option>
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
        getStudents(){
            axios.get('/students').then(response =>{
                response.data.forEach(student => {
                    this.options.push(student);
                });
            });
        },
        customLabel ({admission_number, full_name, year_group}) {
            return `${admission_number} - ${full_name} - Year ${year_group}`
        }
    },
    data () {
        return {
            students: [],
            options: [],
            bottom: 'bottom'
        }
    },
    created(){
        this.getStudents();
    }
}
</script>
