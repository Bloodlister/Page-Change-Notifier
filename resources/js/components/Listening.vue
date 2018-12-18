<template>
    <div>
        <div class="title">{{ this.data.type }}</div>
        <div class="description">
            <p>Brand: {{ searchParams.brand }} | Model: {{ searchParams.model }}</p>
            <p>Price:
                {{ searchParams.startPrice }}{{ searchParams.startPrice ? searchParams.currency : ''}} -
                {{ searchParams.endPrice }}{{ searchParams.endPrice ? searchParams.currency : ''}}</p>
            <p>Year: {{ searchParams.startYear }} - {{ searchParams.endYear }}</p>
        </div>
        <hr>
        <div class="actions">
            <div @click.stop="remove">Remove</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Listening",
    props: {
        id: {
            type: Number,
            required: true,
        },
        data: Object
    },
    computed: {
        searchParams() {
            let data = {};
            if (this.data.search_params !== undefined) {
                if (this.data.search_params['f5'] !== '') {
                    data.brand = this.data.search_params['f5'];
                    data.model = this.data.search_params['f6'];
                }
                if (this.data.search_params['f7'] !== '' || this.data.search_params['f8'] !== '') {
                    data.startPrice = this.data.search_params['f7'];
                    data.endPrice = this.data.search_params['f8'];
                    data.currency = this.data.search_params['f9'];
                }
                if (this.data.search_params['f10'] !== '' || this.data.search_params['f11'] !== '') {
                    data.startYear = this.data.search_params['f10'];
                    data.endYear = this.data.search_params['f11'];
                }
            }

            return data;
        }
    },
    methods: {
        remove() {
            this.$http.post('/filters/delete', {
                filterId: this.id
            }).then(res => {
                if(res.data.success) {
                    this.$emit('resetListenings');
                }
            });
        }
    }
}
</script>