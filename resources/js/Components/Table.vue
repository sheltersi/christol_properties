<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
  columns: Array,
  rows: Array,
  pagination: Object,
});
</script>

<template>
  <div class="overflow-auto">
    <table class="min-w-full border divide-y">
      <thead>
        <tr>
          <th v-for="col in columns" :key="col.key" class="text-left px-3 py-2 bg-gray-100">
            {{ col.label }}
          </th>
          <th class="text-left px-3 py-2 bg-gray-100">Actions</th>
        </tr>
      </thead>
      <!-- <tbody>
        <tr v-for="row in rows" :key="row.id" class="border-b">
          <td v-for="col in columns" :key="col.key" class="px-3 py-2">
            {{ row[col.key] }}
          </td>
          <td class="px-3 py-2">
            <slot name="actions" :row="row" />
          </td>
        </tr>
      </tbody> -->
      <tbody>
  <tr v-for="row in rows" :key="row.id" class="border-b">
    <td v-for="col in columns" :key="col.key" class="px-3 py-2">
      <slot :name="col.key" :row="row">
        {{ row[col.key] }}
      </slot>
    </td>
    <td class="px-3 py-2">
      <slot name="actions" :row="row" />
    </td>
  </tr>
</tbody>

    </table>

    <!-- Pagination -->
    <div class="mt-4 flex space-x-2">
      <template v-for="(link, index) in pagination" :key="index">
        <component
          :is="link.url ? 'button' : 'span'"
          v-html="link.label"
          class="px-3 py-1 text-sm border rounded"
          :class="{ 'bg-blue-600 text-white': link.active }"
          @click="() => router.get(link.url)"
          :disabled="!link.url"
        />
      </template>
    </div>
  </div>
</template>
