<template>
  <div class="grid grid-cols-4 gap-1 mt-2 ml-2">
    <div v-for="tag in tags"
         class="">
      <Card style="width: 20rem; overflow: hidden">
        <template #content>

              <InputText v-model="title"
                         class="!w-full"
                         @value-change="edit_tags(tag)"
                         :disabled="!tag.disabled" :value=" tag.title " type="text"
                         size="small"  />
        </template>

        <template #footer>
          <div class="flex justify-stretch">

                <div class="flex gap-4 mt-1 text-sm mr-4">
                  created: {{ tag.created_at }}
                </div>
            <div class="mx-1 my-1"  v-if="tag.disabled">
              <i class="pi pi-check" style="color: slateblue"
                 @click="send_tags(tag)"
              ></i>
            </div>

            <div class="mx-1 my-1" >
              <i class="pi pi-pencil"
                 @click="edit(tag)"
                 style="color: orange; font-size: 1rem"></i>
            </div>

            <div  class="mx-1 my-1">
              <i class="pi pi-times"
                 style="color: red;font-size: 1rem"></i>
            </div>
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
    // console.log(result);
  });
}

const edit = (t)=>{
  t.disabled = true
}
const edit_tags = (t)=>{

  console.log(title)
}
const send_tags = (t)=>{
t.disabled=false
  console.log(title)
}
</script>

<style>

</style>


