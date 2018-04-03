<!DOCTYPE html>
<html>

<head>
    <title>Twitter Reach UI</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.0"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>

<body>

<div id="app">
    <div class="card">
        <h3 class="card-header bg-dark text-white text-center">Twitter Reach UI</h3>
        <div class="card-body">
            <div class="form-group">
                <label for="url">Tweet URL</label>
                <input type="text" class="form-control" v-model="url"/>
            </div>
            <div class="button-bar">
                <button class="btn btn-dark" @click="submit">Calculate Reach</button>
            </div>
            <div v-if="showReach" class="reach">
                Tweet with id '{{ id }}' has reached '{{ reach }}' followers!
            </div>
            <div v-if="loadingReach" class="reach">
                <div class="spinner fa fa-spin fa-spinner"></div>
            </div>
        </div>
    </div>

</div>

<script>
  var app = new Vue({
    el: '#app',
    data: {
      url: null,
      showReach: false,
      reach: null,
      id: null,
      loadingReach: false,
    },
    methods: {
      submit() {
        this.showReach = false;
        this.loadingReach = true;
        this.parseUrl();
        this.$http.get('/api/tweets/' + this.id + '/reach')
          .then(response => response.json())
          .then(data => {
            this.reach = data.data.reach;
            this.loadingReach = false;
            this.showReach = true;
          });
      },
      parseUrl() {
        let array = this.url.split('status/');
        array = array[1].split('?');
        this.id = array[0];
      },
    },
  });
</script>

<style>
    body {
        font-family: Raleway, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        background-color: #f2f2f3;
    }

    .spinner {
        font-size: 2em;
    }

    .card {
        margin: 3rem;
    }

    .button-bar {
        text-align: right;
    }

    .reach {
        text-align: center;
        font-weight: bold;
        font-size: 1.2em;
        margin-top: 2rem;
        padding: 2rem;
        border: 2px dashed #ccc;
    }
</style>

</body>
</html>
