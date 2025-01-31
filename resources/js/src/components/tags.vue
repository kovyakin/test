<template>
<div  class="grid grid-cols-4 gap-4">
  <div v-for="tag in tags" class=" mx-2 my-2">
    <Card style="width: 20rem; overflow: hidden">
      <template #header>

      </template>
      <template #subtitle>{{tag.title}}</template>
      <template #footer>
        <div class="flex gap-4 mt-1 text-sm">
          created: {{tag.created_at}}
        </div>
      </template>
    </Card>
  </div>
</div>



</template>

<script setup>
import {get} from "../../fetch";
import {onMounted, ref} from "vue";
import Card from 'primevue/card';
import {Button} from "primevue";

const props = defineProps({
  token:String
})

const tags = ref([]);

onMounted(()=>{
  load_tags();
})

const load_tags = ()=>{
get('/api/tags', props.token,'GET' ).then((response) => response.json()).then((result)=>{
  tags.value = result.data;
  console.log(result);
});
}
</script>

<style>

</style>


