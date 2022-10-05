<template>
    <transition name="slide-x-transition" mode="out-in">
        <router-view></router-view>
    </transition>
</template>

<script>
export default {
    name: 'main-app'
}
</script>