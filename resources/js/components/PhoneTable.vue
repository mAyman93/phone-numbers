<template>
    <v-data-table
        :headers="headers"
        :items="tableData"
        :server-items-length="options.total"
        :options.sync="options"
        :loading="loading"
        :footer-props="{
            'items-per-page-options': [10, 20, 30, -1]
        }"
        class="elevation-1"
        fixed-header
        height="400"
    ></v-data-table>
</template>

<script>
export default {
    data() {
        return {
            tableData: [],
            headers: [
                { text: "Country", value: "country" },
                { text: "State", value: "state" },
                { text: "Country Code", value: "countryCode" },
                { text: "Phone num.", value: "phone" }
            ],
            options: {
                page: 1,
                total: 0,
                rowsPerPage: 10
            },
            loading: false
        };
    },
    props: ["filters"],
    mounted() {
        this.getPhoneNumbers();
    },
    watch: {
        options: {
            handler: function(value, oldValue) {
                if(oldValue.itemsPerPage !== value.itemsPerPage || oldValue.page !== value.page) {
                    this.getPhoneNumbers();
                }
            },
            deep: true
        },
        filters: function() {
            this.getPhoneNumbers(this.filters);
        }
    },
    methods: {
        getPhoneNumbers: function(filters = null) {
            this.loading = true;
            var parameters = {
                rowsPerPage: this.options.itemsPerPage,
                page: this.options.page
            };
            parameters = Object.assign({}, parameters, filters);
            axios.get("/phone-numbers", { params: parameters }).then(
                response => {
                    this.tableData = Object.values(response.data.data);
                    this.options.total = response.data.total;
                    this.loading = false;
                },
                error => {}
            );
        }
    }
};
</script>
