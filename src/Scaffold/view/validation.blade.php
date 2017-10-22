<script type="text/x-template" id="tttValidation">
    <table class="table table-striped table-bordered">
        <caption><h3>Validation</h3></caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th>Field</th>
            <th>Fillable</th>
            <th>Hidden</th>
            <th>integer</th>
            <th>numeric</th>
            <th>alpha</th>
            <th>alpha_num</th>
            <th>email</th>
            <th>required</th>
            <th>Between</th>
            <th>RegExp</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in model.validation.list">
            <td>
                <button v-on:click="remove(field)" class="btn btn-danger" type="button">X</button>
            </td>
            <td><input v-model="field.name" class="form-control" type="text"></td>
            <td><input v-model="field.fillable" class="form-control" type="checkbox"></td>
            <td><input v-model="field.hidden" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.integer" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.numeric" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.alpha" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.alpha_num" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.email" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.required" class="form-control" type="checkbox"></td>
            <td><input v-model="field.rule.between" class="form-control" type="text"></td>
            <td><input v-model="field.rule.regex" class="form-control" type="text"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <button v-on:click="add" class="btn btn-primary" type="button">+</button>
            </td>
            <td>
                <button v-on:click="all" class="btn btn-primary" type="button">All</button>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-validation', {
        template: '#tttValidation',
        props: ['model'],
        methods: {
            add: function () {
                let model = this.model;
                let data = {
                    message: 'Select a field',
                    display: 'name',
                    array: vd.entity.table.field.list,
                    callback: function (yes, field) {
                        if (yes) {
                            model.validation.create(field.name);
                        }
                    }
                };
                showChoose(data);
            },
            all: function () {
                this.model.update();
            },
            remove: function (field) {
                if(sure('Are you sure?')){
                    this.model.validation.remove(field);
                }
            }
        }
    });

</script>
