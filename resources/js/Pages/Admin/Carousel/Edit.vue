<!-- resources/js/Pages/Admin/Carousel/Edit.vue -->
<template>
  <AdminLayout
    title="Modifier le slide"
    description="Modifiez un slide du carousel"
  >
    <CarouselForm
      :slide="slide"
      :is-edit="true"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import CarouselForm from '@/Components/CarouselForm.vue'

const props = defineProps({
  slide: Object
})
</script>
