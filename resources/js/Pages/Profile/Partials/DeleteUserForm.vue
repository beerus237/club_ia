<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import { AlertTriangleIcon, TrashIcon } from 'lucide-vue-next';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-5">
        <header class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100">
                <TrashIcon class="h-5 w-5 text-rose-600" />
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Supprimer le compte</h2>
                <p class="text-sm text-slate-500">
                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
                </p>
            </div>
        </header>

        <DangerButton @click="confirmUserDeletion">Supprimer le compte</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100">
                    <AlertTriangleIcon class="h-6 w-6 text-rose-600" />
                </div>

                <h2 class="text-lg font-bold text-slate-900">Êtes-vous sûr de vouloir supprimer votre compte ?</h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
                    Entrez votre mot de passe pour confirmer.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Mot de passe" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Mot de passe"
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="closeModal">Annuler</SecondaryButton>

                    <DangerButton :class="{ 'opacity-50': form.processing }" :disabled="form.processing" @click="deleteUser">
                        Supprimer le compte
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
