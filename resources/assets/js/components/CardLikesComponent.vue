<template>
  <span class="pull-right">
    <i class="fa text-success" v-bind:class="up" v-on:click="$_like"></i> {{ likes }} &nbsp;
    <i class="fa text-danger" v-bind:class="down" v-on:click="$_dislike"></i> {{ dislikes }}
  </span>
</template>

<script>

export default {
  props: ['card', 'likes', 'dislikes'],
  data() {
    return {
      liked: false,
      disliked: false,
    }
  },
  computed: {
    up() {
      return this.liked === true ? 'fa-thumbs-up' : 'fa-thumbs-o-up'
    },
    down() {
      return this.disliked === true ? 'fa-thumbs-down' : 'fa-thumbs-o-down'
    },
  },
  mounted() {
    this.$_liked_update()
  },
  methods: {
    $_liked_update() {
      var api = '/cards/' + this.card + '/likes'
      var self = this
      axios.get(api)
        .then(function (response) {
          if(response.data === 'liked') {
            self.liked = true
            self.disliked = false
          } else if(response.data === 'disliked') {
            self.liked = false
            self.disliked = true
          } else {
            self.liked = false
            self.disliked = false
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    $_like() {
      var api = '/cards/' + this.card + '/likes'
      var self = this
      axios.post(api, {type: 'like'})
        .then(function (response) {
          self.likes++
          self.liked = true
          self.disliked = false
          if(self.dislikes > 0) {
            self.dislikes--
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    $_dislike() {
      var api = '/cards/' + this.card + '/likes'
      var self = this
      axios.post(api, {type: 'dislike'})
        .then(function (response) {
          self.dislikes++
          self.disliked = true
          self.liked = false
          if(self.likes > 0) {
            self.likes--
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
}
</script>