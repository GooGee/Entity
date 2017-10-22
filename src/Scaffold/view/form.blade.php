@verbatim
<script type="text/x-template" id="tttForm">
    <table class="table table-striped table-bordered">
        <caption>
            <h3>Form
            </h3>
        </caption>
        <thead>
        <tr>
            <th width="150px"></th>
            <th>Field</th>
            <th>Type</th>
            <th>Value</th>
            <th>v-model</th>
            <th>Label</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in form.field.list">
            <td>
                <div class="btn-group">
                    <button v-on:click="moveUp(field)" class="btn btn-primary" type="button">↑</button>
                    <button v-on:click="moveDown(field)" class="btn btn-primary" type="button">↓</button>
                </div>
                <button v-on:click="remove(field)" class="btn btn-danger" type="button">X</button>
            </td>
            <td>{{field.name}}</td>
            <td><select v-model="field.type" class="form-control">
                    <option value="text">text</option>
                    <option value="password">password</option>
                    <option value="hidden">hidden</option>
                    <option value="textarea">textarea</option>
                    <option value="checkbox">checkbox</option>
                    <option value="radio">radio</option>
                    <option value="select">select</option>
                </select></td>
            <td><input v-model="field.value" class="form-control" type="text"></td>
            <td><input v-model="field.vModel" class="form-control" type="text"></td>
            <td><input v-model="field.label" class="form-control" type="text"></td>
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
            <td>
                <div class="btn-group">
                    <button v-on:click="method('GET')" v-bind:class="methodGet" type="button">GET</button>
                    <button v-on:click="method('POST')" v-bind:class="methodPost" type="button">POST</button>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <button v-on:click="method('PATCH')" class="btn btn-info" type="button">PATCH</button>
                    <button v-on:click="method('DELETE')" class="btn btn-info" type="button">DELETE</button>
                </div>
            </td>
            <td>
                <input v-model="form.instance" class="form-control" type="text">
            </td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>
@endverbatim


<script type="text/javascript">

    Vue.component('ccc-form', {
        template: '#tttForm',
        props: ['form'],
        computed: {
            methodGet: function () {
                if ('GET' == this.form.method) {
                    return 'btn btn-info active';
                }
                return 'btn btn-info';
            },
            methodPost: function () {
                if ('POST' == this.form.method) {
                    return 'btn btn-info active';
                }
                return 'btn btn-info';
            }
        },
        methods: {
            add: function () {
                let name = input('Please enter the Field name');
                if (isEmpty(name)) {
                    return;
                }
                this.form.field.create(name, 'text');
            },
            all: function () {
                this.form.update();
            },
            remove: function (field) {
                if (sure('Are you sure?')) {
                    this.form.field.remove(field);
                }
            },
            method: function (method) {
                if (method == 'GET') {
                    this.form.method = method;
                    return;
                }

                this.form.method = 'POST';
                if (method == 'PATCH') {
                    let patch = this.form.field.create('_method', 'hidden');
                    patch.value = 'patch';
                }

                if (method == 'DELETE') {
                    let del = this.form.field.create('_method', 'hidden');
                    del.value = 'delete';
                }
            },
            moveUp: function (field) {
                this.form.field.moveUp(field);
            },
            moveDown: function (field) {
                this.form.field.moveDown(field);
            }
        }
    });

</script>
