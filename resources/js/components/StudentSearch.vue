<template lang="html">
    <ais-index :search-store="searchStore"  index-name="students">
        <div class="navbar-search navbar-search-dark mr-3 ml-lg-auto">
            <div class="form-group mb-0">
                <div class="search-input input-group input-group-alternative">
                    <ais-input :class-names="{'ais-input' : 'form-control'}" placeholder="Search"></ais-input>
                </div>
                <div class="text-right mr-2">
                    <ais-powered-by></ais-powered-by>
                </div>
            </div>
            <ul class="student-search w-100 list-group mt-2" v-show="searchStore.query.length > 0">
                <ais-results>
                    <template slot-scope="{ result }">
                        <li class="list-group-item d-flex align-items-center">
                            <img class="search-icon mr-1" src="/images/search-icon.svg" alt="generic user profile image">
                            <a :href='showStudent(result.id)'>
                                {{result.forename + ' ' + result.surname}}
                                <small class="d-block text-muted">
                                    Year group: {{result.year_group}}
                                </small>
                            </a>
                        </li>
                    </template>
                </ais-results>
            </ul>
        </div>
    </ais-index>
</template>

<script>
import {createFromAlgoliaCredentials} from 'vue-instantsearch';
const searchStore = createFromAlgoliaCredentials('N9H85PFJ44', '558648aceba7916f274eb28fe0b890ac');
export default {
    data() {
        return { searchStore };
    },
    methods: {
        showStudent(id){
            return route('students.show', {id: id}).url()
        }
    }
}
</script>

<style lang="css">
    .navbar-search{
        position: relative;
    }
    .search-icon{
        height: 50px;
        width: 50px;
    }
    .ais-powered-by > a > svg {
        width: 100px;
    }
</style>
