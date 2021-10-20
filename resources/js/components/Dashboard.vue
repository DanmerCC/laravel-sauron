<template>
  <div class="row">
    <div class="col-12">
      <user-selector></user-selector>
    </div>
    <div class="col-12">
      <heat-map
        :tooltipEnabled="true"
        :colorRange="['#c9ecec', '#09b3af']"
        :locale="{
        months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        days: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
        No: 'No',
        on: 'on',
        Less: 'Less',
        More: 'More'
}"
      ></heat-map>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
<style lang="scss">
.text {
  font: 14pt sans-serif;
  fill: red;
}
svg {
  border: 1px solid silver;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  overflow: visible;
}
</style>
