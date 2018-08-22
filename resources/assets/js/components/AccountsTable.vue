<template>
  <table class="table mt-5">
    <thead>
      <tr>
        <td>Account Name</td>
        <td>Created</td>
        <td>Actions</td>
      </tr>
    </thead>
    <tbody>
      <tr v-if="accounts.length === 0">
        <td colspan="3">
          There are no accounts.
        </td>
      </tr>
      <tr
        v-for="account in accounts"
        :key="account.id">
        <td>
          <input
            v-if="editAccountId === account.id"
            v-model="editAccountName"
            type="text"
            class="form-control">
          <span v-if="editAccountId !== account.id">{{ account.name }}</span>
        </td>
        <td>{{ account.created_at }}</td>
        <td>
          <div v-if="editAccountId === account.id" class="btn-group">
            <button @click="saveAccount(editAccount)" class="btn btn-primary">Save</button>
            <button @click="cancelEdit()" class="btn btn-warning">Cancel</button>
          </div>
          <div v-if="editAccountId !== account.id" class="btn-group">
            <button @click="editAccount(account)" class="btn btn-primary">Edit</button>
            <button @click="deleteAccount(account)" class="btn btn-danger">Remove</button>
          </div>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3">
          <form @submit.prevent="addAccount">
            <div class="input-group w-50">
              <input
                v-model="newAccountName"
                type="text"
                class="form-control"
                >
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </div>
          </form>
        </td>
      </tr>
    </tfoot>
  </table>
</template>

<script>
  let axios = require('axios');

  export default {
    data: function () {
      return {
        accounts: [],
        newAccountName: null,
        editAccountId: null,
        editAccountName: null,
      }
    },
    created() {
      this.refreshAccounts();
    },
    methods: {
      refreshAccounts: function () {
        let _this = this;
        axios.get('/api/accounts')
          .then(function (response) {
            _this.accounts = response.data;
          });
      },
      addAccount: function () {
        let _this = this;
        axios.post('/api/accounts', { name: this.newAccountName })
          .then(function (response) {
            _this.newAccountName = '';
            _this.refreshAccounts();
          });
      },
      editAccount: function (account) {
        this.editAccountId = account.id;
        this.editAccountName = account.name;
      },
      cancelEdit: function () {
        this.editAccountId = null;
        this.editAccountName = account.name;
      },
      saveAccount: function (account) {
        let _this = this;
        axios.put('/api/accounts/' + this.editAccountId, { name: this.editAccountName })
          .then(function (response) {
            _this.editAccountId = null;
            _this.editAccountName = null;
            _this.refreshAccounts();
          });
      },
      deleteAccount: function (account) {
        let _this = this;
        axios.delete('/api/accounts/' + account.id)
          .then(function (response) {
            _this.refreshAccounts();
          });
      },
    }
  }
</script>
