<template>
  <div>
    <div>
      <div class="flex items-center justify-between">
        <span class="text-2xl">OAuth Clients</span>

        <button
          class="px-4 py-2 font-extrabold text-white bg-indigo-500 rounded hover:bg-indigo-800"
          @click="showCreateClientForm"
        >Create New Client</button>
      </div>

      <table v-if="clients.length >0" class="table mx-auto mt-5 mb-20">
        <thead class="text-white bg-indigo-500">
          <tr>
            <th scope="col" class="border">ID</th>
            <th scope="col" class="border">Name</th>
            <th scope="col" class="border">Secret</th>
            <th scope="col" class="border">Actions</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="client in clients" :key="client.id" class="border">
            <th scope="row" class="border">{{ client.id }}</th>
            <td class="border">{{ client.name }}</td>
            <td class="border">
              <code>{{ client.secret }}</code>
            </td>
            <!-- Edit Button -->
            <td class="border">
              <a class="px-2 text-indigo-800 cursor-pointer" @click="edit(client)">Edit</a>
              <a class="px-2 text-red-500 cursor-pointer" @click="destroy(client)">Delete</a>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else role="alert" class="pt-5 mb-20">
        <div class="px-4 py-2 font-extrabold text-white bg-indigo-500 rounded-t">Oops!</div>
        <div
          class="px-4 py-3 text-indigo-800 bg-indigo-100 border border-t-0 border-indigo-300 rounded-b"
        >
          <p>You Dont Have Any Client Yet. Please Create a New Client</p>
        </div>
      </div>
    </div>
    <!-- create modal -->
    <div v-if="showCreateModal">
      <div class="fixed inset-0 flex items-center">
        <div class="fixed inset-0 z-10 bg-black opacity-75"/>

        <div class="relative z-20 w-full m-8 mx-6 md:mx-auto md:w-1/2 lg:w-1/3">
          <div class="p-8 bg-white rounded-lg shadow-lg">
            <div class="flex justify-end mb-6">
              <button @click="close(createForm)" class="flex items-center text-red-500">
                <span class="mr-2">Close</span>
                <svg viewBox="0 0 20 20" class="h-4 fill-current">
                  <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                </svg>
              </button>
            </div>

            <h1 class="text-2xl text-center text-indigo-800">Create Client</h1>

            <form class="pt-6 pb-2 my-2">
              <div class="mb-4">
                <label class="block mb-2 text-sm font-extrabold" for="name">Name</label>
                <input
                  id="name"
                  v-model="createForm.name"
                  :class="{ 'border-red': createForm.errors.has('name') }"
                  class="block w-full h-full px-3 py-3 pr-3 text-gray-700 bg-gray-100 border rounded outline-none appearance-none focus:border-indigo-300 pl-9"
                  type="text"
                  placeholder="Something your users will recognize and trust."
                  @keyup.enter="store"
                >
                <has-error :form="createForm" class="text-red" field="name"/>
              </div>
              <div class="mb-6">
                <label class="block mb-2 text-sm font-extrabold" for="redirecturl">Redirect Url</label>
                <input
                  id="redirecturl"
                  v-model="createForm.redirect"
                  :class="{ 'border-red-500': createForm.errors.has('redirect') }"
                  class="block w-full h-full px-3 py-3 pr-3 text-gray-700 bg-gray-100 border rounded outline-none appearance-none focus:border-indigo-300 pl-9"
                  type="text"
                  placeholder="Your application's authorization callback URL."
                  @keyup.enter="store"
                >
                <has-error :form="createForm" class="text-red" field="redirect"/>
              </div>
              <div class="block clearfix">
                <button
                  class="float-right px-4 py-2 font-extrabold text-white bg-indigo-500 rounded hover:bg-indigo-800"
                  type="button"
                  @click="store"
                >Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- create modal -->
    <!-- edit modal -->
    <div v-if="showEditModal">
      <div class="fixed inset-0 flex items-center">
        <div class="fixed inset-0 z-10 bg-black opacity-75"/>

        <div class="relative z-20 w-full m-8 mx-6 md:mx-auto md:w-1/2 lg:w-1/3">
          <div class="p-8 bg-white rounded-lg shadow-lg">
            <div class="flex justify-end mb-6">
              <button @click="close(editForm)" class="flex items-center text-red-500">
                <span class="mr-2">Close</span>
                <svg viewBox="0 0 20 20" class="h-4 fill-current">
                  <path d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"/>
                </svg>
              </button>
            </div>

            <h1 class="text-2xl text-center text-indigo-800">Edit Client</h1>

            <form class="pt-6 pb-2 my-2">
              <div class="mb-4">
                <label class="block mb-2 text-sm font-extrabold" for="name">Name</label>
                <input
                  id="name"
                  v-model="editForm.name"
                  :class="{ 'border-red-500': editForm.errors.has('name') }"
                  class="block w-full h-full px-3 py-3 pr-3 text-gray-700 bg-gray-100 border rounded outline-none appearance-none focus:border-indigo-300 pl-9"
                  type="text"
                  placeholder="Something your users will recognize and trust."
                  @keyup.enter="update"
                >
                <has-error :form="editForm" class="text-red-500" field="name"/>
              </div>
              <div class="mb-6">
                <label class="block mb-2 text-sm font-extrabold" for="redirecturl">Redirect Url</label>
                <input
                  id="redirecturl"
                  v-model="editForm.redirect"
                  :class="{ 'border-red-500': editForm.errors.has('redirect') }"
                  class="block w-full h-full px-3 py-3 pr-3 text-gray-700 bg-gray-100 border rounded outline-none appearance-none focus:indigo-300 pl-9"
                  type="text"
                  placeholder="Your application's authorization callback URL."
                  @keyup.enter="update"
                >
                <has-error :form="editForm" class="text-red-500" field="redirect"/>
              </div>
              <div class="block clearfix">
                <button
                  class="float-right px-4 py-2 font-extrabold text-white bg-indigo-500 rounded hover:bg-indigo-800"
                  type="button"
                  @click="update"
                >Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- edit modal -->
  </div>
</template>

<script>
import { Form, HasError } from "vform";

Vue.component(HasError.name, HasError);

export default {
  data() {
    return {
      clients: [],

      createForm: new Form({
        name: "",
        redirect: ""
      }),

      editForm: new Form({
        name: "",
        redirect: ""
      }),
      showCreateModal: false,
      showEditModal: false
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
    close(form) {
      this.showCreateModal = false;
      this.showEditModal = false;
      form.clear();
    },
    /**
     * Prepare the component.
     */
    prepareComponent() {
      this.getClients();
    },

    /**
     * Get all of the OAuth clients for the user.
     */
    getClients() {
      axios.get("/oauth/clients").then(response => {
        this.clients = response.data;
      });
    },

    /**
     * Show the form for creating new clients.
     */
    showCreateClientForm() {
      this.showCreateModal = true;
    },

    /**
     * Create a new OAuth client for the user.
     */
    store() {
      this.persistClient("post", "/oauth/clients", this.createForm);
    },

    /**
     * Edit the given client.
     */
    edit(client) {
      this.editForm.id = client.id;
      this.editForm.name = client.name;
      this.editForm.redirect = client.redirect;

      this.showEditModal = true;
    },

    /**
     * Update the client being edited.
     */
    update() {
      this.persistClient(
        "put",
        "/oauth/clients/" + this.editForm.id,
        this.editForm
      );
    },

    /**
     * Persist the client to storage using the given form.
     */
    persistClient(method, uri, form) {
      form[method](uri).then(response => {
        this.getClients();

        form.name = "";
        form.redirect = "";
        this.close(form);
      });
    },

    /**
     * Destroy the given client.
     */
    destroy(client) {
      axios.delete("/oauth/clients/" + client.id).then(response => {
        this.getClients();
      });
    }
  }
};
</script>
