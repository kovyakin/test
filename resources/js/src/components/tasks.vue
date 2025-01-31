<template>
  <div class="container text-center">
    <div class="row mt-2">
      <Button label="Добавить" severity="secondary" variant="text" raised size="small"
              @click="visible_dialog_add = true"
      />
    </div>

  </div>
  <div class="grid grid-cols-4 gap-1 mt-2 ml-2">
    <div v-for="task in tasks"
         :key=task.id
         class="">
      <Card style="width: 20rem; overflow: hidden">
        <template #content>

          <InputText v-model="title"
                     class="!w-full "
                     :class="task.validate"
                     @value-change="edit_tasks(task)"
                     :disabled="!task.disabled"
                     :value=" task.title "
                     type="text"
                     size="small"/>
        </template>

        <template #footer>
          <div class="flex justify-stretch">

            <div class="flex gap-4 mt-1 text-sm mr-4">
              created: {{ task.created_at }}
            </div>
            <div class="mx-1 my-1"
                 v-if="task.disabled && task.validate == null">
              <i class="pi pi-check"
                 style="color: slateblue"
                 @click="send_tasks(task)"
              ></i>
            </div>

            <div class="mx-1 my-1">
              <i class="pi pi-pencil"
                 @click="edit(task)"
                 style="color: orange; font-size: 1rem"></i>
            </div>

            <div class="mx-1 my-1">
              <i class="pi pi-times"
                 @click="confirm_delete(task)"
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
      <label for="todotask" class="font-semibold w-24">task</label>
      <InputText id="todotask" v-model="new_task"
                 class="!w-full"
                 :class = "class_validate_new_task"
                 @value-change="add_tasks()"
                 type="text"
                 size="small" autocomplete="off"

      />
    </div>

    <div class="flex justify-end gap-2">
      <Button type="button" label="Cancel" severity="secondary" @click="visible_dialog_add = false"></Button>
      <Button type="button" label="Save" @click="send_new_task"
              :disabled = "!(class_validate_new_task === '' &&  new_task !== '') "
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

const tasks = ref([]);
const title = ref(null);
const visible_dialog_add = ref(false);
const new_task = ref('');
const class_validate_new_task = ref('');


onMounted(() => {
  load_tasks();

})

const load_tasks = () => {

  get('/api/tasks', props.token, 'GET').then((response) => response.json()).then((result) => {
    tasks.value = result.data;

  });
}

const edit = (t) => {
  t.disabled = true
}
const edit_tasks = (t) => {
  const index = tasks.value.findIndex((el) => el.id === t.id);
  tasks.value[index].title = title.value;
  if (title.value.length > 3 && title.value.length < 21) {
    // tasks.value[index].title = title.value;
    tasks.value[index].validate = null;
  } else {
    tasks.value[index].validate = '!text-red-500';
  }
}


const send_tasks = (t) => {
  t.disabled = false
  if (t.validate == null) {

    get('/api/tasks/' + t.id, props.token, 'PUT', t.title).then((response) => response.json()).then((result) => {
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
const send_new_task = () => {

  if (class_validate_new_task.value === '' && new_task.value.length > 0) {

    get('/api/tasks', props.token, 'POST', new_task.value).then((response) => response.json()).then((result) => {

      if (result.result === 'success') {
        visible_dialog_add.value = false;
        new_task.value ='';
        load_tasks();
        toast.add({ severity: 'success', summary: 'Успешно', detail: 'Запись создана', life: 2000 });
      }
      else if(result.result === 'error'){
        toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Ошибка создания записи', life: 2000 });
      }
    });
  }
}


const add_tasks = () => {
  if(new_task.value.length >3 && new_task.value.length<21){
    class_validate_new_task.value = '';
  }
  else{
    class_validate_new_task.value = '!text-red-500';
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

      get('/api/tasks/' + t.id, props.token, 'DELETE', t.title).then((response) => response.json()).then((result) => {
        if (result.result === 'success') {
          load_tasks();
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


