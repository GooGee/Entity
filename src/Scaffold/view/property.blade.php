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
            <td>
                <span v-if="button">
                    <button v-on:click="change(key, value)" class="btn btn-default" type="button">@brace('object[key]')</button>
                </span>
                <span v-else>
                    <input v-model="object[key]" class="form-control" type="text">
                </span>
            </td>
        </tr>
        </tbody>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-property', {
        template: '#tttProperty',
        props: {
            object: Object,
            button: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            change: function (key, value) {
                let name = input('Please enter the ' + key, value);
                if (isEmpty(name)) {
                    return;
                }
                this.object.change(key, name);
            }
        }
    });

</script>
