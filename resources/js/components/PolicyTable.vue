<template lang="html">
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Policy Name</th>
                <th scope="col">Read</th>
                <th scope="col">Read on</th>
                <th scope="col">Delete Policies</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="policy in policies">
                <th scope="row">
                    <a target="_blank" href="#"  @click.prevent="markAsRead(policy)">
                        {{policy.name}}
                    </a>
                </th>
                <td>
                    <button v-if="policy.pivot.read_at" disabled type="button" class="btn btn-sm btn-success">Read</button>
                    <button v-else disabled type="button" class="btn btn-sm btn-danger">Unread</button>
                </td>
                <td>
                    {{policy.pivot.read_at ? moment(policy.pivot.read_at).format('MMMM Do YYYY') : '-'}}
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" @click.prevent="deletePolicy(policy)">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import moment from 'moment';
export default {
    data(){
        return {
            policies: []
        }
    },
    methods:{
        moment: function () {
            return moment();
        },
        getPolicies(){
            axios.get('/policies').then(response => {
                response.data.forEach(policy => {
                    this.policies.push(policy);
                })
            });
        },
        markAsRead(policy){
            policy.pivot.read_at = moment().format('MMMM Do YYYY, h:mm:ss a');
            axios.get(route('policies.show', {id: policy.id}))
            .then(response => {
                window.open(response.data);
            })

        },
        deletePolicy(policy){
            axios.delete(route('policies.destroy', {id: policy.id}))
            .then(response =>{
                window.location.replace(route('settings'));
            })
        }
    },
    created(){
        this.getPolicies();
    }
}
</script>
