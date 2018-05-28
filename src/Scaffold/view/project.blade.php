<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Entity</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
    <style>

        .border
        {
            border: 1px solid darkgray;
            border-radius: 3px;
        }

        .mr
        {
            margin-right: 6px;
        }

    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script type="text/javascript" src="/js/entity.js"></script>
</head>
<body>
<!--[if lt IE 11]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="entity">

    @include('entity::header')

    <div class="container">

        <!-- File -->
        <div v-show="tab=='file'">
            <h3>File
                <span v-on:click="refresh" class="btn btn-warning">Refresh</span>
            </h3>
            <table class="table">
                <tr v-for="file in fileList">
                    <td>
                        <span v-text="file"></span>
                        <span v-on:click="load(file)" class="btn btn-warning">Load</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span v-on:click="create" class="btn btn-warning">New</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Project -->
        <div v-if="project && tab=='project'">
            <h3>
                <span v-text="project.name"></span>
                <span v-on:click="save" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="project" :button="true"></ccc-property>

            <!-- Entry -->
            <ccc-entry :project="project" v-on:show="showEntry"></ccc-entry>
        </div>

        <!-- Migration -->
        <div v-if="entry && tab=='table'">
            <h3>
                <span v-text="entry.table.name"></span> Table
                <span v-on:click="saveMigration" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.table"></ccc-property>

            <!-- Field -->
            <ccc-field :table="entry.table"></ccc-field>

            <!-- Index -->
            <ccc-index :table="entry.table"></ccc-index>
        </div>

        <!-- Seed -->
        <div v-if="entry && tab=='seed'">
            <h3>
                <span v-text="entry.factory.name"></span>
                <span v-on:click="saveFactory" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.factory"></ccc-property>

            <!-- Factory -->
            <ccc-factory :factory="entry.factory"></ccc-factory>
        </div>

        <!-- Model -->
        <div v-if="entry && tab=='model'">
            <h3>
                <span v-text="entry.model.name"></span> Model
                <span v-on:click="saveModel" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.model"></ccc-property>

            <!-- Relation -->
            <ccc-relation :model="entry.model" :project="project"></ccc-relation>

            <!-- Validation -->
            <ccc-validation :model="entry.model"></ccc-validation>
        </div>

        <!-- Controller -->
        <div v-if="entry && tab=='controller'">
            <h3>
                <span v-text="entry.controller.name"></span>
                <span v-on:click="saveController" class="btn btn-success">Save</span>
            </h3>

            <!-- Property -->
            <ccc-property :object="entry.controller"></ccc-property>

            <!-- Middleware -->
            <ccc-middleware :controller="entry.controller"></ccc-middleware>
        </div>


        <!-- Form -->
        <div v-if="entry && tab=='form'">
            <h3>
                <span v-text="entry.name"></span> Form
                <span v-on:click="saveForm" class="btn btn-success">Save</span>
            </h3>

            <!-- Form -->
            <ccc-form :form="entry.form"></ccc-form>
        </div>

    </div>


    <!-- Choose -->
    <ccc-choose v-show="choose.visible" :data="choose.data" v-on:close="close"></ccc-choose>

</div>
<br>

@include('entity::dialogue')
@include('entity::choose')

@include('entity::property')
@include('entity::entry')
@include('entity::field')
@include('entity::index')
@include('entity::factory')
@include('entity::relation')
@include('entity::validation')
@include('entity::middleware')
@include('entity::form')

<script type="text/javascript">

    function choose(data) {
        vvv.choose.data = data;
        vvv.choose.visible = true;
    }

    const vm = {};

    vm.close = function () {
        this.choose.visible = false;
    };

    vm.show = function (tab) {
        this.tab = tab;
    };

    vm.showEntry = function (entry) {
        this.entry = entry;
        this.show('table');
    };

    vm.setFileList = function (list) {
        if (Array.isArray(list)) {
            this.fileList = list;
        }
    };

    vm.warn = function () {
        if (this.project == null) {
            return true;
        }
        return confirm('Warning!\nAll unsaved changes will be lost!\nContinue?');
    };

    vm.refresh = function () {
        if (this.warn()) {
            location.reload();
        }
    };

    vm.create = function () {
        if (this.warn()) {
            // ok
        } else {
            return;
        }

        let name = prompt('Please enter the file name', 'entity.json');
        if (name) {
            name = name.replace(' ', '');
            if (this.fileList.indexOf(name) > -1) {
                alert(name + ' already exists!');
                return;
            }

            this.file = name;
            this.project = new Project(name);
            this.show('project');
        }
    };

    vm.load = function (name) {
        if (this.warn()) {
            // ok
        } else {
            return;
        }

        let me = this;
        get('/entity/load?file=' + name, function (json) {
            let ppp = JSON.parse(json.data);
            me.file = name;
            me.project = new Project(ppp.file);
            me.project.load(ppp);
            me.show('project');
        });
    };

    vm.save = function () {
        let data = {
            file: this.file,
            project: JSON.stringify(this.project)
        };
        save('/entity', data);
    };

    vm.saveMigration = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/table', data);
    };

    vm.saveModel = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/model', data);
    };

    vm.saveFactory = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/factory', data);
    };

    vm.saveController = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/controller', data);
    };

    vm.saveForm = function () {
        let data = {
            entry: JSON.stringify(this.entry)
        };
        save('/entity/form', data);
    };


    const vvv = new Vue({
        el: '#entity',
        data: {
            tab: 'file',
            choose: {
                visible: false,
                data: {
                    message: '',
                    display: null,
                    array: [],
                    callback: null
                }
            },
            file: null,
            fileList: [],
            entry: null,
            project: null
        },
        created: function () {
            this.setFileList(<?php echo json_encode($fileList); ?>);
        },
        methods: vm
    });

</script>

</body>
</html>