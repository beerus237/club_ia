<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Mon profil" />

    <AdminLayout title="Mon profil" description="Gérez vos informations de compte et votre sécurité">
        <div class="mx-auto max-w-3xl space-y-6">
            <div class="surface-card p-6 sm:p-8">
                <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
            </div>

            <div class="surface-card p-6 sm:p-8">
                <UpdatePasswordForm />
            </div>

            <div class="surface-card p-6 sm:p-8">
                <DeleteUserForm />
            </div>
        </div>
    </AdminLayout>
</template>
