<template>
  <h4 class="fw-bold my-4" v-if="showData">Place to visit</h4>

  <ul class="list-group">
    <li class="list-group-item" v-for="place in relatedPlaces" :key="place.id">{{place.properties.formatted}}</li>
  </ul>
</template>
<script setup>
defineProps({
  showData: false,
  relatedPlaces: Object
})


</script>
