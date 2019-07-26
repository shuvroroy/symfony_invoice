<script>
    import PaginationComponent from './PaginationComponent';

    export default {
        name: 'data-table-component',
        components: {
            PaginationComponent
        },
        props: ['dataItems'],
        data() {
            return {
                search: '',
                current: 1,
                paginate: 10,
                total: 0,
                items: this.dataItems
            }
        },
        computed: {
            filteredList() {
                let data = this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.email.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.address.toLowerCase().includes(this.search.toLowerCase()) ||
                        item.phone.includes(this.search);
                });

                this.total = data.length;
                return data;
            }
        },
        methods: {

        }
    }
</script>

<style>
    [v-cloak] {
        display: none;
    }
</style>