<template>
  <div>
    <froala :tag="'textarea'" :config="config" v-model="model"></froala>
  </div>
</template>

<script>
export default {
  name: "app",
  data() {
    return {
      config: {
        placeholder: "Edit Me",
        events: {
          "froalaEditor.focus": function (e, editor) {
            console.log(editor.selection.get());
          },
        },
      },
    };
  },
};
</script>