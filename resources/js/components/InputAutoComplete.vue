<template>
  <div class="list-group position-absolute w-100" v-if="form.hideAutoComplete">
    <a v-for="city in form.autocomplete" :key="city.id" @click="selectCity(city.properties)" href="#"
       class="list-group-item list-group-item-action"><span>{{ city.properties.formatted }}</span></a>
  </div>
</template>
<script setup>
defineProps({
  form: Object,
})

const emit = defineEmits(['selectCity']);

const selectCity = (value) => {
  emit('selectCity', value)
}

</script>
