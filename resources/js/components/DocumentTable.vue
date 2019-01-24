<template lang="html">
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
                <th scope="col">Document Name</th>
                <th scope="col">Read</th>
                <th scope="col">Read on</th>
                <th scope="col">Delete Documents</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="document in documents">
                <th scope="row">
                    <a target="_blank" href="#"  @click.prevent="markAsRead(document)">
                        {{document.name}}
                    </a>
                </th>
                <td>
                    <button v-if="document.pivot.read_at" disabled type="button" class="btn btn-sm btn-success">Read</button>
                    <button v-else disabled type="button" class="btn btn-sm btn-danger">Unread</button>
                </td>
                <td>
                    {{document.pivot.read_at ? moment(document.pivot.read_at).format('MMMM Do YYYY') : '-'}}
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" @click.prevent="deleteDocument(document)">Remove</button>
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
            documents: []
        }
    },
    methods:{
        moment: function () {
            return moment();
        },
        getDocuments(){
            axios.get('/documents/all').then(response => {
                response.data.forEach(document => {
                    this.documents.push(document);
                })
            });
        },
        markAsRead(document){
            document.pivot.read_at = moment().format('MMMM Do YYYY, h:mm:ss a');
            axios.get(route('documents.show', {id: document.id}))
            .then(response => {
                window.open(response.data);
            })
        },
        deleteDocument(document){
            axios.delete(route('documents.destroy', {id: document.id}))
            .then(response =>{
            })
            location.reload();
        }
    },
    created(){
        this.getDocuments();
    }
}
</script>
