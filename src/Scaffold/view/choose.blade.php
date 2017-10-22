<script type="text/x-template" id="tttChoose">

    <div class="choose">
        <div class="layer"></div>
        <div class="panel">
            <div class="margin"><span>@brace('data.message')</span></div>
            <div class="margin">
                <select v-model="data.item" class="form-control">
                    <option v-for="item in data.array" v-bind:value="item">@brace('display(item)')</option>
                </select>
            </div>
            <div class="margin">
                <button v-on:click="yes" class="btn btn-success" type="button">V</button>
                <button v-on:click="no" class="btn btn-danger" type="button">X</button>
            </div>
        </div>
    </div>

</script>


<script type="text/javascript">

    const choose = new Choose();

    function showChoose(data) {
        choose.show(data);
    }

    function hideChoose() {
        choose.hide();
    }

    Vue.component('ccc-choose', {
        template: '#tttChoose',
        props: ['data'],
        methods: {
            display: function (item) {
                if (this.data.display) {
                    return item[this.data.display];
                }
                return item;
            },
            yes: function () {
                if (this.data.item) {
                    if (this.data.callback) {
                        this.data.callback(true, this.data.item);
                    }
                    hideChoose();
                }
            },
            no: function () {
                if (this.data.callback) {
                    this.data.callback(false);
                }
                hideChoose();
            }
        }
    });

</script>
