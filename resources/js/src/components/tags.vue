<template>
  <div class="grid grid-cols-4 gap-1 mt-2 ml-2">
    <div v-for="tag in tags"
         class="">
      <Card style="width: 20rem; overflow: hidden">
        <template #content>

          <div class="grid grid-cols-12 ">
            <div >
              <InputText v-model="title"  :value=" tag.title " type="text"
                         size="small"  />
            </div>
            <div class="col-start-11 flex justify-content-end" >
              <i class="pi pi-pencil"
                 style="color: orange; font-size: 1rem"></i>
            </div>

            <div  class="col-start-12 flex justify-content-end">
              <i class="pi pi-times"
                 style="color: red;font-size: 1rem"></i>
            </div>
          </div>
        </template>

        <template #footer>

          <div class="flex gap-4 mt-1 text-sm">
            created: {{ tag.created_at }}
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
import InputText from 'primevue/inputtext';
import Divider from 'primevue/divider';

const props = defineProps({
  token: String
})

const tags = ref([]);
const title = ref(null)
onMounted(() => {
  load_tags();
})

const load_tags = () => {
  get('/api/tags', props.token, 'GET').then((response) => response.json()).then((result) => {
    tags.value = result.data;
    console.log(result);
  });
}
</script>

<style>

</style>


