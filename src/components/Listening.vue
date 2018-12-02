<template>
    <div class="listening">
        <div class="title">{{ type }}</div>
        <div class="description">{{ description }}</div>
        <div class="actions">
            <div @click.stop="remove">x</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Listening",
    props: {
        id: {
            type: String,
            required: true,
        },
        data: Object
    },
    methods: {
        remove() {
            axios.post('/listening/delete', {
                listeningId: this.id
            });
        }
    }
}
</script>