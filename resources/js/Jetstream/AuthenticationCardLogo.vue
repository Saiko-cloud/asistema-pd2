<template>
    <Link :href="'/'">
        <img src="/images/logo.png" width="80" height="80">
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
    })
</script>
