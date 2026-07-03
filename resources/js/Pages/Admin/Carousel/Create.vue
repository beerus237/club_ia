<!-- resources/js/Pages/Admin/Carousel/Create.vue -->
<template>
  <AdminLayout
    title="Créer un slide"
    description="Ajoutez un nouveau slide au carousel"
  >
    <CarouselForm
      :is-edit="false"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import CarouselForm from '@/Components/CarouselForm.vue'
</script>
