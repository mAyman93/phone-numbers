<template>
    <v-app>
        <Header />
        <v-main class="blue-grey lighten-5">
            <v-container fluid>
                <Filters :countries="countries" @filters-changed="listenToFiltersChange" />
                <PhoneTable :filters="filters" />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import Header from './components/Header';
import Filters from './components/Filters';
import PhoneTable from './components/PhoneTable';
export default {
    components: {
        Header,
        Filters,
        PhoneTable
    },
    data() {
        return {
            countries: [],
            tableData: [],
            selectedCountry: "",
            selectedState: "",
            filters: {}
        }
    },
    mounted() {
        this.getCountries();
    },
    methods: {
        getCountries: function() {
            axios.get("/countries").then(
                response => {
                    this.countries = response.data;
                },
                error => {}
            );
        },
        listenToFiltersChange: function(filters) {
            this.filters = filters;
        }
    }
};
</script>
