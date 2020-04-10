<template>
  <div>
    <div>
      <div class="flex items-center justify-between">
        <span class="text-2xl">OAuth Clients</span>

        <button
          class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded"
          @click="showCreateClientForm"
        >Create New Client</button>
      </div>

      <table v-if="clients.length >0" class="table mb-20 mt-5 mx-auto">
        <thead class="bg-blue-500 text-white">
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
              <a class="cursor-pointer text-blue-500 px-2" @click="edit(client)">Edit</a>
              <a class="cursor-pointer text-red-500 px-2" @click="destroy(client)">Delete</a>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else role="alert" class="mb-20 pt-5">
        <div class="bg-blue-500 text-white font-bold rounded-t px-4 py-2">Oops!</div>
        <div
          class="border border-t-0 border-blue-400 rounded-b bg-blue-100 px-4 py-3 text-blue-600"
        >
          <p>You Dont Have Any Client Yet. Please Create a New Client</p>
        </div>
      </div>
    </div>
    <!-- create modal -->
    <div v-if="showCreateModal">
      <div class="fixed inset-0 flex items-center">
        <div class="fixed inset-0 bg-black opacity-75 z-10"/>

        <div class="relative mx-6 md:mx-auto w-full md:w-1/2 lg:w-1/3 z-20 m-8">
          <div class="shadow-lg bg-white rounded-lg p-8">
            <div class="flex justify-end mb-6">
              <button @click="close(createForm)">
                <span class="mr-2 text-red">Close</span>
                <span>
                  <i class="fa fa-times"/>
                </span>
              </button>
            </div>

            <h1 class="text-center text-2xl text-blue-600">Create Client</h1>

            <form class="pt-6 pb-2 my-2">
              <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="name">Name</label>
                <input
                  id="name"
                  v-model="createForm.name"
                  :class="{ 'border-red': createForm.errors.has('name') }"
                  class="block appearance-none outline-none w-full h-full border focus:border-blue bg-gray-100 text-gray-700 px-3 py-3 pr-3 pl-9 rounded"
                  type="text"
                  placeholder="Something your users will recognize and trust."
                  @keyup.enter="store"
                >
                <has-error :form="createForm" class="text-red" field="name"/>
              </div>
              <div class="mb-6">
                <label class="block text-sm font-bold mb-2" for="redirecturl">Redirect Url</label>
                <input
                  id="redirecturl"
                  v-model="createForm.redirect"
                  :class="{ 'border-red': createForm.errors.has('redirect') }"
                  class="block appearance-none outline-none w-full h-full border focus:border-blue bg-gray-100 text-gray-700 px-3 py-3 pr-3 pl-9 rounded"
                  type="text"
                  placeholder="Your application's authorization callback URL."
                  @keyup.enter="store"
                >
                <has-error :form="createForm" class="text-red" field="redirect"/>
              </div>
              <div class="block clearfix">
                <button
                  class="float-right bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded border-b-4 border-blue-800"
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
        <div class="fixed inset-0 bg-black opacity-75 z-10"/>

        <div class="relative mx-6 md:mx-auto w-full md:w-1/2 lg:w-1/3 z-20 m-8">
          <div class="shadow-lg bg-white rounded-lg p-8">
            <div class="flex justify-end mb-6">
              <button @click="close(editForm)">
                <span class="mr-2 text-red">Close</span>
                <span>
                  <i class="fa fa-times"/>
                </span>
              </button>
            </div>

            <h1 class="text-center text-2xl text-blue-600">Edit Client</h1>

            <form class="pt-6 pb-2 my-2">
              <div class="mb-4">
                <label class="block text-sm font-bold mb-2" for="name">Name</label>
                <input
                  id="name"
                  v-model="editForm.name"
                  :class="{ 'border-red': editForm.errors.has('name') }"
                  class="block appearance-none outline-none w-full h-full border focus:border-blue bg-gray-100 text-gray-700 px-3 py-3 pr-3 pl-9 rounded"
                  type="text"
                  placeholder="Something your users will recognize and trust."
                  @keyup.enter="update"
                >
                <has-error :form="editForm" class="text-red" field="name"/>
              </div>
              <div class="mb-6">
                <label class="block text-sm font-bold mb-2" for="redirecturl">Redirect Url</label>
                <input
                  id="redirecturl"
                  v-model="editForm.redirect"
                  :class="{ 'border-red': editForm.errors.has('redirect') }"
                  class="block appearance-none outline-none w-full h-full border focus:border-blue bg-gray-100 text-gray-700 px-3 py-3 pr-3 pl-9 rounded"
                  type="text"
                  placeholder="Your application's authorization callback URL."
                  @keyup.enter="update"
                >
                <has-error :form="editForm" class="text-red" field="redirect"/>
              </div>
              <div class="block clearfix">
                <button
                  class="float-right bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded border-b-4 border-blue-800"
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
