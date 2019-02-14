<template lang="html">
    <div>
        <multiselect v-model="value" :options="options" :searchable="false" :close-on-select="false" :show-labels="false" placeholder="Select a type">
        </multiselect>
        <input type="hidden" name="type" :value="value" />
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'

export default {
    components: {
        Multiselect
    },
    data () {
        return {
            value: '',
            options: [
                'Observation',
                'Disclosure'
            ],
            bottom: 'bottom'
        }
    }
}
</script>
