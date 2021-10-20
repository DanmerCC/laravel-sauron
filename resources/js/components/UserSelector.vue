<template>
  <v-select v-model="value" :options="users" @search="fetchOptions" label="username"></v-select>
</template>

<script>
export default {
  data() {
    return {
      value: null,
      users: []
    };
  },
  methods: {
    getData(search = null) {
      console.log("Cargando");

      let data = search == null ? {} : { params: { search } };
      return axios
        .get(`/api/users`, data)
        .then(response => {
          console.log(response.data);
          this.options = response.data;
        })
        .catch(error => console.error(error));
    },
    fetchOptions(search, loading) {
      loading(true);
      this.getData(search).then(loading(false));
    }
  },
  mounted() {
    this.getData(null);
  }
};
</script>

<style>
</style>
