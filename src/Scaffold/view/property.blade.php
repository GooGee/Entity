<script type="text/x-template" id="tttProperty">
    <table class="table table-striped table-bordered">
        <caption>
            <h3>Property</h3>
        </caption>
        <thead>
        <tr>
            <th style="width: 155px">Name</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(value, key) in object" v-if="typeof(value) == 'string'">
            <td>@brace('key')</td>
            <td><input v-model="object[key]" class="form-control" type="text"></td>
        </tr>
        </tbody>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-property', {
        template: '#tttProperty',
        props: ['object']
    });

</script>
