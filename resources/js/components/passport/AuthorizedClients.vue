<template>
  <div>
    <div>
      <div class="flex items-center justify-between">
        <span class="text-2xl">Authorized Clients</span>
      </div>
      <table v-if="tokens.length >0" class="table mx-auto mt-5 mb-20">
        <thead class="text-white bg-indigo-500">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Scopes</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(token,index) in tokens" :key="index">
            <td class="border">{{ token.client.name }}</td>
            <td class="border">
              <span v-if="token.scopes.length > 0">{{ token.scopes.join(', ') }}</span>
            </td>
            <!-- Edit Button -->
            <td class="border">
              <a class="text-red-500 cursor-pointer" @click="revoke(token)">Revoke</a>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else role="alert" class="pt-5 mb-20">
        <div class="px-4 py-2 font-extrabold text-white bg-indigo-500 rounded-t">Oops!</div>
        <div
          class="px-4 py-3 text-indigo-800 bg-indigo-100 border border-t-0 border-indigo-300 rounded-b"
        >
          <p>You Dont Have Any Authorized Clients Yet!</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  /*
   * The component's data.
   */
  data() {
    return {
      tokens: []
    };
  },

  /**
   * Prepare the component (Vue 1.x).
   */
  ready() {
    this.prepareComponent();
  },

  /**
   * Prepare the component (Vue 2.x).
   */
  mounted() {
    this.prepareComponent();
  },

  methods: {
    /**
     * Prepare the component (Vue 2.x).
     */
    prepareComponent() {
      this.getTokens();
    },

    /**
     * Get all of the authorized tokens for the user.
     */
    getTokens() {
      axios.get("/oauth/tokens").then(response => {
        this.tokens = response.data;
      });
    },

    /**
     * Revoke the given token.
     */
    revoke(token) {
      axios.delete("/oauth/tokens/" + token.id).then(response => {
        this.getTokens();
      });
    }
  }
};
</script>
