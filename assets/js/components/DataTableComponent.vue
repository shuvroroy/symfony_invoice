<script>
    import moment from 'moment';

    export default {
        name: 'data-table-component',
        props: ['dataItems'],
        data() {
            return {
                search: '',
                pageNumber: 0,
                totalPage: 0,
                perPage: 10,
                prev: false,
                next: true,
                items: this.dataItems
            }
        },
        filters: {
            moment(date) {
                return moment(date).format('DD/MM/YYYY');
            }
        },
        computed: {
            filteredProductList() {
                let data = this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.description.toLowerCase().includes(this.search.toLowerCase());
                });

                if (data.length <= this.perPage) {
                    this.next = false;
                    this.prev = false;
                }

                this.totalPage = Math.ceil(data.length / this.perPage);
                const start = this.pageNumber * this.perPage;
                const end = start + this.perPage;
                return data.slice(start, end);

            },
            filteredClientList() {
                let data = this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.email.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.address.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.phone.includes(this.search);
                });

                if (data.length <= this.perPage) {
                    this.next = false;
                    this.prev = false;
                }

                this.totalPage = Math.ceil(data.length / this.perPage);
                const start = this.pageNumber * this.perPage;
                const end = start + this.perPage;
                return data.slice(start, end);

            },
            filteredInvoiceList() {
                let data = this.items.filter(item => {
                    return item.number.includes(this.search) ||
                        item.client.name.toLowerCase().includes(this.search.toLowerCase());
                });

                if (data.length <= this.perPage) {
                    this.next = false;
                    this.prev = false;
                }

                this.totalPage = Math.ceil(data.length / this.perPage);
                const start = this.pageNumber * this.perPage;
                const end = start + this.perPage;
                return data.slice(start, end);

            }
        },
        methods:{
            nextPage(){
                this.pageNumber++;
            },
            prevPage(){
                this.pageNumber--;
            }
        },
        watch: {
            search(val) {
                if (val === '') {
                    this.next = true;
                    if (this.pageNumber > 0) {
                        this.prev = true;
                    }
                }
            },
            pageNumber() {
                if (this.pageNumber >= (this.totalPage - 1)) {
                    this.next = false;
                } else {
                    this.next = true;
                }
                if (this.pageNumber === 0 ) {
                    this.prev = false;
                } else {
                    this.prev = true;
                }
            }
        }
    }
</script>

<style>
    [v-cloak] {
        display: none;
    }
</style>