<template>
    <div v-show="message">
        <p class="mt-2 text-sm text-red-600 dark:text-red-600">
           <span class="font-medium">Oops!</span> {{ message }}
        </p>
    </div>
</template>

<script>
export default {
    props: ['message']
}
</script>
