<script type="text/x-template" id="tttEntity">
    <table class="table table-striped table-bordered">
        <caption><h3>Entity</h3></caption>
        <thead>
        <tr>
            <th width="200px"></th>
            <th>Table</th>
            <th>Factory</th>
            <th>Model</th>
            <th>Controller</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="entity in project.entity.list">
            <td>
                <div class="btn-group">
                    <span v-on:click="project.entity.moveUp(entity)" class="btn btn-info">↑</span>
                    <span v-on:click="project.entity.moveDown(entity)" class="btn btn-info">↓</span>
                </div>
                <span v-on:click="show(entity)" class="btn btn-primary">Show</span>
                <span v-on:click="remove(entity)" class="btn btn-danger">X</span>
            </td>
            <td><input v-model="entity.table.name" class="form-control" type="text"></td>
            <td><input v-model="entity.factory.name" class="form-control" type="text"></td>
            <td><input v-model="entity.model.name" class="form-control" type="text"></td>
            <td><input v-model="entity.controller.name" class="form-control" type="text"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <span v-on:click="add" class="btn btn-primary">+</span>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-entity', {
        template: '#tttEntity',
        props: ['project'],
        methods: {
            add: function () {
                let name = prompt('Please enter the Entity name');
                if (name) {
                    this.project.entity.create(name);
                }
            },
            show: function (entity) {
                this.$emit('show', entity);
            },
            remove: function (entity) {
                if(confirm('Are you sure?')){
                    this.project.entity.remove(entity);
                }
            }
        }
    });

</script>
