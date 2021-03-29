<template>
  <div>
    <div>
      <div class="flex items-center justify-between">
        <span class="text-2xl">Personal Tokens</span>

        <button
          class="px-4 py-2 font-extrabold text-white bg-indigo-800 rounded hover:bg-indigo-500"
          @click="showCreateTokenForm"
        >Create New Token</button>
      </div>
      <!-- Personal Access Tokens -->
      <table v-if="tokens.length >0" class="table w-full mx-auto mt-5 mb-20">
        <thead class="py-2 text-white bg-indigo-500">
          <tr>
            <td class="py-2 pl-4 text-left border font-extraextrabold">Name</td>
            <td class="py-2 pr-4 text-right border font-extraextrabold">Actions</td>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(token,index) in tokens" :key="index">
            <td scope="row" class="py-3 pl-3 text-left border">{{ token.name }}</td>
            <td scope="row" class="py-3 pr-3 text-right border">
              <a class="text-red-500 cursor-pointer" @click="revoke(token)">Delete</a>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- No Tokens Notice -->
      <div v-else role="alert" class="pt-5 mb-20">
        <div class="px-4 py-2 text-white bg-indigo-500 rounded-t font-extraextrabold">Attention needed.</div>
        <div
          class="px-4 py-3 text-indigo-800 bg-indigo-100 border border-t-0 border-indigo-300 rounded-b"
        >
          <p>You Don't Have Any Personal Tokens Yet. Please Create a New Personal Token.</p>
        </div>
      </div>
    </div>

    <!-- Create Token Modal -->
    <div v-if="showCreateModal">
      <div class="fixed inset-0 flex items-center">
        <div class="fixed inset-0 z-10 bg-black opacity-75"/>

        <div class="relative z-20 w-full m-8 mx-6 md:mx-auto md:w-1/2 lg:w-1/3">
          <div class="p-8 bg-white rounded-lg shadow-lg">
            <div class="flex justify-end mb-6">
              <button @click="showCreateModal = false" class="flex items-center text-red-500">
                <span class="mr-2">Close</span>
                <svg viewBox="0 0 20 20" class="h-4 fill-current">
                  <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                </svg>
              </button>
            </div>

            <h1 class="text-2xl text-center text-indigo-800">Create Token</h1>

            <form class="pt-6 pb-2 my-2" @submit.prevent="store">
              <div class="mb-4">
                <label class="block mb-2 text-sm font-extrabold" for="name">Name</label>
                <input
                  id="name"
                  v-model="form.name"
                  :class="{ 'border-red-500': form.errors.has('name') }"
                  class="block w-full h-full px-3 py-3 pr-3 text-gray-700 bg-gray-100 border rounded outline-none appearance-none focus:border-indigo-300 pl-9"
                  placeholder="Name Your Token"
                  type="text"
                  @keyup.enter="store"
                >
                <has-error :form="form" class="text-red-500" field="name"/>
              </div>

              <div v-if="scopes.length > 0" class="flex flex-wrap mb-4">
                <label class="w-full pt-2 pb-2 pl-4 pr-4 mb-0 -ml-4 font-extrabold leading-normal">Scopes</label>

                <div class="w-full pl-4 pr-4">
                  <div v-for="(scope,index) in scopes" :key="index">
                    <div class="checkbox">
                      <label>
                        <input
                          :checked="scopeIsAssigned(scope.id)"
                          type="checkbox"
                          @click="toggleScope(scope.id)"
                        >
                        {{ scope.id }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="block clearfix">
                <button
                  class="float-right px-4 py-2 font-extrabold text-white bg-indigo-800 rounded hover:bg-indigo-500"
                  type="button"
                  @click="store"
                >Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showAccessTokenModal">
      <div class="fixed inset-0 flex items-center">
        <div class="fixed inset-0 z-10 bg-black opacity-75"/>

        <div class="relative z-20 w-full m-8 mx-6 md:mx-auto md:w-1/2 lg:w-1/3">
          <div class="p-8 bg-white rounded-lg shadow-lg">
            <div class="flex justify-end mb-6">
              <button @click="showAccessTokenModal = false" class="flex items-center text-red-500">
                <span class="mr-2">Close</span>
                <svg viewBox="0 0 20 20" class="h-4 fill-current">
                  <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                </svg>
              </button>
            </div>

            <h1 class="pb-5 text-2xl text-center text-indigo-800">Personal Access Token</h1>
            <p class="pb-5 text-lg tracking-tight text-justify text-gray-700">
              Here is your new personal access token. This is the only time it will be shown so don't lose it!
              You may now use this token to make API requests.
            </p>
            <textarea
              v-model="accessToken"
              class="block w-full px-2 py-1 mb-1 text-base leading-normal text-gray-700 bg-white border border-gray-500 rounded appearance-none"
              rows="10"
            />
          </div>
        </div>
      </div>
    </div>
    <!-- Access Token Modal -->
  </div>
</template>

<script>
import Form from "vform";

export default {
  data() {
    return {
      accessToken: null,
      tokens: [],
      scopes: [],
      form: new Form({
        name: "",
        scopes: []
      }),
      showCreateModal: false,
      showAccessTokenModal: false
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
     * Prepare the component.
     */
    prepareComponent() {
      this.getTokens();
      this.getScopes();
    },

    /**
     * Get all of the personal access tokens for the user.
     */
    getTokens() {
      axios.get("/oauth/personal-access-tokens").then(response => {
        this.tokens = response.data;
      });
    },

    /**
     * Get all of the available scopes.
     */
    getScopes() {
      axios.get("/oauth/scopes").then(response => {
        this.scopes = response.data;
      });
    },

    /**
     * Show the form for creating new tokens.
     */
    showCreateTokenForm() {
      this.showCreateModal = true;
    },

    /**
     * Create a new personal access token.
     */
    store() {
      this.accessToken = null;

      this.form
        .post("/oauth/personal-access-tokens", this.form)
        .then(response => {
          this.form.name = "";
          this.form.scopes = [];

          this.tokens.push(response.data.token);
          this.showCreateModal = false;
          this.showAccessToken(response.data.accessToken);
        });
    },

    /**
     * Toggle the given scope in the list of assigned scopes.
     */
    toggleScope(scope) {
      if (this.scopeIsAssigned(scope)) {
        this.form.scopes = _.reject(this.form.scopes, s => s == scope);
      } else {
        this.form.scopes.push(scope);
      }
    },

    /**
     * Determine if the given scope has been assigned to the token.
     */
    scopeIsAssigned(scope) {
      return _.indexOf(this.form.scopes, scope) >= 0;
    },

    /**
     * Show the given access token to the user.
     */
    showAccessToken(accessToken) {
      this.accessToken = accessToken;

      this.showAccessTokenModal = true;
    },

    /**
     * Revoke the given token.
     */
    revoke(token) {
      axios
        .delete("/oauth/personal-access-tokens/" + token.id)
        .then(response => {
          this.getTokens();
        });
    }
  }
};
</script>
