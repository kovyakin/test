<template>
  <div class="container text-center">
    <div class="row mt-2">
      <Button label="Добавить"
              severity="secondary"
              variant="text"
              raised
              size="small"
              @click="visible_dialog_add = true"
      />
    </div>

  </div>
  <div class="grid grid-cols-4 gap-1 mt-2 ml-2">
    <div v-for="task in tasks"
         :key=task.id
         class="">
      <Card style="width: 20rem; overflow: hidden">
        <template #title  > <span class="flex justify-content-center text-uppercase">
          {{task.title}}
        </span></template>
        <template #subtitle>
          <Panel header="tags" toggleable collapsed size="small">
                   <p v-for="tags in task.tags_id">
            {{ tags.title }}
          </p>
          </Panel>
        </template>

        <template #content>{{task.text}}</template>

        <template #footer>
          <div class="flex justify-stretch">

            <div class="flex gap-4 mt-1 text-sm mr-4">
              created: {{ task.created_at }}
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
  <Toast/>
  <ConfirmDialog></ConfirmDialog>

  <Dialog v-model:visible="visible_dialog_add"
          modal
          :header="is_edit ? 'Редактировать запись' : 'Добавить новую запись'"
          :style="{ width: '25rem' }">
    <div class="flex items-center">
      <div class="gridgrid-rows-3">
        <div>
          <label for="todotask"
                 class="font-semibold w-24">title</label>
          <InputText id="todotask"
                     v-model="new_task"
                     :invalid="new_task?.length <3"
                     class="!w-full"
                     :class="class_validate_new_task"
                     @value-change="add_tasks()"
                     type="text"
                     placeholder="От 3 до 20 символов."
                     size="small"
                     autocomplete="off"
          />
        </div>
        <div>
          <label for="text"
                 class="font-semibold w-24">text</label>
          <Textarea id="text"
                    v-model="text_value"
                    :invalid="text_value?.length <3"
                    :class="class_validate_new_text"
                    @value-change ="add_text()"
                    variant="filled"
                    placeholder="От 3 до 200 символов."
                    style="resize: none"
                    size="small"
                    rows="10"
                    cols="50"/>
        </div>

        <div class=" mb-2">
          <label for="tags"
                 class="font-semibold w-24">tags</label>

          <MultiSelect v-model="selectedItems"
                       :options="items"
                       :maxSelectedLabels="3"
                       :selectAll="selectAll"
                       optionLabel="title"
                       optionValue="id"
                       @selectall-change="onSelectAllChange($event)"
                       @change="onChange($event)"
                       :virtualScrollerOptions="{ itemSize: 30 }"
                       filter
                       placeholder="Выберите tags"
                       size="small"
                       class="w-full"/>

        </div>
      </div>

    </div>

    <div class="flex justify-end gap-2">
      <Button type="button"
              label="Отмена"
              severity="secondary"
              @click="reset"></Button>
      <Button type="button"
              label="Сохранить"
              @click="send_new_task"
              :disabled="!(class_validate_new_task === '' &&  new_task !== '') "
      ></Button>
    </div>
  </Dialog>

</template>

<script setup>
import {get} from "../../fetch";
import {onMounted, ref} from "vue";
import Card from 'primevue/card';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import {useToast} from "primevue";
import ConfirmDialog from 'primevue/confirmdialog';
import {useConfirm} from "primevue/useconfirm";
import {Button} from "primevue";
import Dialog from 'primevue/dialog';
import {Textarea} from "primevue";
import MultiSelect from 'primevue/multiselect';

import Panel from 'primevue/panel';

const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
  token: String
})

const tasks = ref([]);
const text_value = ref(null);
const visible_dialog_add = ref(false);
const new_task = ref('');
const class_validate_new_task = ref('');
const class_validate_new_text = ref('');


const selectedItems = ref([]);
const selectAll = ref(false);
const items = ref([]);
const is_edit = ref(false);
const id_edit_task = ref();

onMounted(() => {
  load_tasks();
  load_tags();
})

const load_tasks = () => {

  get('/api/tasks', props.token, 'GET').then((response) => response.json()).then((result) => {
    tasks.value = result.data;
  });
}

const load_tags = () => {
  get('/api/tags', props.token, 'GET').then((response) => response.json()).then((result) => {
    items.value = result.data;

  });
}

const edit = (t) => {

const id = ref([]);
      t.tags_id.map((el)=>{
        id.value.push(el.id);
  });

  is_edit.value = true;
  id_edit_task.value = t.id;
  visible_dialog_add.value=true;
  new_task.value = t.title;
  text_value.value = t.text;
  selectedItems.value =  id.value;
}

const send_new_task = () => {

  if (class_validate_new_task.value === '' &&
      new_task.value.length > 0 &&
      class_validate_new_text.value === '' &&
      text_value.value.length > 0
  ) {

    let method = 'POST';
    let url = '/api/tasks';
    if(is_edit.value){
      method = 'PUT';
      url = url +'/'+ id_edit_task.value;
    }

    get(url, props.token, method,[ new_task.value, text_value.value, selectAll.value, selectedItems.value]).then((response) =>
        response.json()).then((result) => {

      if (result.result === 'success') {
        visible_dialog_add.value = false;
        load_tasks();
        toast.add({severity: 'success', summary: 'Успешно', detail: is_edit.value ? 'Запись отредактирована' :
              'Запись создана', life: 2000});

      } else if (result.result === 'error') {
        toast.add({severity: 'error', summary: 'Ошибка', detail: is_edit.value?'Ошибка редактирования записи' :
              'Ошибка создания записи', life: 2000});
      }
      reset();
    });
  }
}


const add_tasks = () => {
  if (new_task.value.length > 3 && new_task.value.length < 21) {
    class_validate_new_task.value = '';
  } else {
    class_validate_new_task.value = '!text-red-500';
  }
}

const add_text = () => {
  if (text_value.value.length > 3 && text_value.value.length < 201) {
    class_validate_new_text.value = '';
  } else {
    class_validate_new_text.value = '!text-red-500';
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
          toast.add({severity: 'success', summary: 'Успешно', detail: 'Удалено', life: 2000});
        } else if (result.result === 'error') {
          toast.add({severity: 'error', summary: 'Ошибка', detail: 'Ошибка удаления', life: 2000});
        }

      });

      // toast.add({ severity: 'info', summary: 'Confirmed', detail: 'You have accepted', life: 2000 });
    },
    reject: () => {
      toast.add({severity: 'error', summary: 'Отмена', detail: 'Удаление отменено', life: 2000});
    }
  });
};

const onSelectAllChange = (event) => {
  selectedItems.value = event.checked ? items.value.map((item) => item.value) : [];
  selectAll.value = event.checked;
};
const onChange = (event) => {
  selectAll.value = event.value.length === items.value.length;
}

const reset = ()=>{
  visible_dialog_add.value = false;
  new_task.value = '';
  text_value.value = '';
  selectedItems.value = [];
  selectAll.value=false;
  is_edit.value = false;
}

</script>

<style>

</style>


