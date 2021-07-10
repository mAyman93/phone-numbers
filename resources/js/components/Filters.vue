<template>
    <v-row>
        <v-col cols="4">
            <v-select
                v-model="selectedCountry"
                :items="countries"
                label="Select country"
                @change="sendFilters"
                outlined
            ></v-select>
        </v-col>
        <v-col cols="4">
            <v-select
                v-model="selectedState"
                :items="states"
                label="Select phone validity"
                @change="sendFilters"
                outlined
            ></v-select>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            states: [
                { text: "Valid", value: 1 },
                { text: "Not Valid", value: 0 }
            ],
            selectedCountry: null,
            selectedState: null
        };
    },
    props: {
        countries: Array
    },
    methods: {
        sendFilters: function() {
            this.$emit("filters-changed", {
                country: this.selectedCountry,
                state: this.selectedState
            });
        }
    }
};
</script>

<style>
.v-select > .v-input__control > .v-input__slot {
    cursor: pointer;
    background-color: white;
}
</style>
