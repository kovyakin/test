<template>
  <div class="grid grid-cols-4 gap-1 mt-2 ml-2">
    <div v-for="tag in tags"
         :key=tag.id
         class="">
      <Card style="width: 20rem; overflow: hidden">
        <template #content>

          <InputText v-model="title"
                     class="!w-full "
                     :class="tag.validate"
                     @value-change="edit_tags(tag)"
                     :disabled="!tag.disabled"
                     :value=" tag.title "
                     type="text"
                     size="small"/>
        </template>

        <template #footer>
          <div class="flex justify-stretch">

            <div class="flex gap-4 mt-1 text-sm mr-4">
              created: {{ tag.created_at }}
            </div>
            <div class="mx-1 my-1"
                 v-if="tag.disabled && tag.validate == null">
              <i class="pi pi-check"
                 style="color: slateblue"
                 @click="send_tags(tag)"
              ></i>
            </div>

            <div class="mx-1 my-1">
              <i class="pi pi-pencil"
                 @click="edit(tag)"
                 style="color: orange; font-size: 1rem"></i>
            </div>

            <div class="mx-1 my-1">
              <i class="pi pi-times"
                 @click="confirm_delete(tag)"
                 style="color: red;font-size: 1rem"></i>
            </div>
          </div>

        </template>
      </Card>

    </div>
  </div>
  <Toast  />
  <ConfirmDialog></ConfirmDialog>
</template>

<script  setup>
import {get} from "../../fetch";
import {onMounted, ref} from "vue";
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import {useToast} from "primevue";
import ConfirmDialog from 'primevue/confirmdialog';
import { useConfirm } from "primevue/useconfirm";

const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
  token: String
})

const tags = ref([]);
const title = ref(null);


onMounted(() => {
  load_tags();

})

const load_tags = () => {
  get('/api/tags', props.token, 'GET').then((response) => response.json()).then((result) => {
    tags.value = result.data;

  });
}

const edit = (t) => {
  t.disabled = true
}
const edit_tags = (t) => {
  const index = tags.value.findIndex((el) => el.id === t.id);
  tags.value[index].title = title.value;
  if (title.value.length > 3 && title.value.length < 21) {
    // tags.value[index].title = title.value;
    tags.value[index].validate = null;
  } else {
    tags.value[index].validate = '!text-red-500';


  }

}
const send_tags = (t) => {
  t.disabled = false
  if (t.validate == null) {

    get('/api/tags/' + t.id, props.token, 'PUT', t.title).then((response) => response.json()).then((result) => {
      if (result.result === 'success') {
        toast.add({ severity: 'success', summary: 'Успешно', detail: 'Изменения сохранены', life: 2000 });
      }
      else if(result.result === 'error'){
        toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Ошибка сохранения', life: 2000 });
      }

    });
  }
  // console.log(title)
}

const confirm_delete = (t) => {
  confirm.require({
    message: 'Вы хотите удалить запись?',
    header: 'Подтверждение удаления',
    icon: 'pi pi-exclamation-triangle',
    rejectProps: {
      label: 'Отменить',
      severity: 'secondary',
      outlined: true
    },
    acceptProps: {
      label: 'Удалить',
      severity: 'danger',
    },
    accept: () => {

      get('/api/tags/' + t.id, props.token, 'DELETE', t.title).then((response) => response.json()).then((result) => {
        if (result.result === 'success') {
          toast.add({ severity: 'success', summary: 'Успешно', detail: 'Удалено', life: 2000 });
        }
        else if(result.result === 'error'){
          toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Ошибка удаления', life: 2000 });
        }

      });

      // toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 2000 });
    },
    reject: () => {
      toast.add({ severity: 'error', summary: 'Отмена', detail: 'Удаление отменено', life: 2000 });
    }
  });
};


</script>

<style>

</style>


