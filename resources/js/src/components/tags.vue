<template>
  <div class="container text-center">
    <div class="row mt-2">
      <Button label="Добавить" severity="secondary" variant="text" raised size="small"
              @click="visible_dialog_add = true"
      />
    </div>

  </div>
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

  <Dialog v-model:visible="visible_dialog_add" modal header="Добавить новую запись" :style="{ width: '25rem' }">
    <span class="text-surface-500 dark:text-surface-400 block mb-8">От 3 до 20 символов.</span>
    <div class="flex items-center gap-4 mb-4">
      <label for="todotag" class="font-semibold w-24">Tag</label>
      <InputText id="todotag" v-model="new_tag"
                 :invalid="new_tag?.length < 3"
                 class="!w-full"
                 :class = "class_validate_new_tag"
                 @value-change="add_tags()"
                 type="text"
                 size="small" autocomplete="off"

      />
    </div>

    <div class="flex justify-end gap-2">
      <Button type="button" label="Cancel" severity="secondary" @click="reset"></Button>
      <Button type="button" label="Save" @click="send_new_tag"
              :disabled = "!(class_validate_new_tag === '' &&  new_tag !== '') "
      ></Button>
    </div>
  </Dialog>
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
import {Button} from "primevue";
import Dialog from 'primevue/dialog';

const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
  token: String
})

const tags = ref([]);
const title = ref(null);
const visible_dialog_add = ref(false);
const new_tag = ref('');
const class_validate_new_tag = ref('');


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
const send_new_tag = () => {

  if (class_validate_new_tag.value === '' && new_tag.value.length > 0) {

    get('/api/tags', props.token, 'POST', new_tag.value).then((response) => response.json()).then((result) => {

      if (result.result === 'success') {
        visible_dialog_add.value = false;
        new_tag.value ='';
        load_tags();
        toast.add({ severity: 'success', summary: 'Успешно', detail: 'Запись создана', life: 2000 });
      }
      else if(result.result === 'error'){
        toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Ошибка создания записи', life: 2000 });
      }
    });
  }
}


const add_tags = () => {
  if(new_tag.value.length >3 && new_tag.value.length<21){
    class_validate_new_tag.value = '';
  }
  else{
    class_validate_new_tag.value = '!text-red-500';
  }
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
          load_tags();
          toast.add({ severity: 'success', summary: 'Успешно', detail: 'Удалено', life: 2000 });
        }
        else if(result.result === 'error'){
          toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Ошибка удаления', life: 2000 });
        }

      });

    },
    reject: () => {
      toast.add({ severity: 'error', summary: 'Отмена', detail: 'Удаление отменено', life: 2000 });
    }
  });
};
const reset = ()=>{
  visible_dialog_add.value = false;
  new_tag.value = '';
}

</script>

<style>

</style>


