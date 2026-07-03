<template>
  <AdminLayout
    title="Tableau de bord"
    description="Vue d'ensemble de l'administration"
    :stats="stats"
  >
    <div class="space-y-6">
      <!-- Cartes de statistiques -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <StatCard
          title="Actualités"
          :value="stats.actualites_count"
          :icon="NewspaperIcon"
          color="brand"
          to="/admin/actualites"
        />
        <StatCard
          title="Événements"
          :value="stats.evenements_count"
          :icon="CalendarIcon"
          color="emerald"
          to="/admin/evenements"
        />
        <StatCard
          title="Projets"
          :value="stats.projets_count"
          :icon="FolderOpenIcon"
          color="amber"
          to="/admin/projets"
        />
        <StatCard
          title="Contributions en attente"
          :value="stats.contributions_pending"
          :icon="ShieldIcon"
          color="rose"
          to="/admin/contributions"
        />
      </div>

      <!-- Grille principale -->
      <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <DashboardCard
          title="Contributions à modérer"
          action-label="Voir tout"
          action-to="/admin/contributions"
        >
          <ContributionsList :contributions="recentContributions" />
        </DashboardCard>

        <DashboardCard title="Activité récente">
          <ActivityTimeLine :activities="recentActivities" />
        </DashboardCard>
      </div>

      <!-- Actions rapides -->
      <DashboardCard title="Actions rapides">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <QuickAction title="Nouvelle actualité" :icon="PlusIcon" to="/admin/actualites/create" color="brand" />
          <QuickAction title="Nouvel événement" :icon="PlusIcon" to="/admin/evenements/create" color="emerald" />
          <QuickAction title="Nouveau projet" :icon="PlusIcon" to="/admin/projets/create" color="amber" />
          <QuickAction title="Modérer les contributions" :icon="ShieldIcon" to="/admin/contributions" color="rose" />
        </div>
      </DashboardCard>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import ContributionsList from '@/Components/Admin/ContributionsList.vue'
import ActivityTimeLine from '@/Components/Admin/ActivityTimeLine.vue'
import QuickAction from '@/Components/Admin/QuickAction.vue'
import { NewspaperIcon, CalendarIcon, FolderOpenIcon, ShieldIcon, PlusIcon } from 'lucide-vue-next'

defineProps({
  stats: Object,
  recentContributions: Array,
  recentActivities: Array,
})
</script>
