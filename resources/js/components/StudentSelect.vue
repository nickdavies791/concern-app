<template lang="html">
    <div>
        <multiselect :options-limit="3" :open-direction="bottom" v-model="students" :options="options" :multiple="true" :close-on-select="true"
        :clear-on-select="false" :preserve-search="true" placeholder="Select a student" :custom-label="customLabel" track-by="id">
            <template slot="singleLabel" slot-scope="props"><img class="option__image rounded-circle" :src="'/storage/students/'+props.option.mis_id+'.jpg'"><span class="option__desc"><span class="option__title">{{ props.option.full_name }}</span></span></template>
            <template slot="option" slot-scope="props"><img class="option__image rounded-circle" style="width:80px;height:80px;object-fit:cover;display:inline;" :src="'/storage/students/'+props.option.mis_id+'.jpg'">
                <div class="option__desc" style="display:inline;"><span class="option__title">{{ props.option.full_name }}</span> - Year <span class="option__small">{{ props.option.year_group }}</span></div>
            </template>
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
