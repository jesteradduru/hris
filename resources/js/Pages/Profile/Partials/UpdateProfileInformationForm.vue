<template>
  <section>
    <header>
      <h4 class="text-lg font-medium text-gray-900">
        Profile Information
      </h4>

      <p class="mt-1 text-sm text-gray-600">
        Update your account's profile information and username.
      </p>
    </header>

    <form class="mt-6 space-y-6" @submit.prevent="form.post(route('profile.update'))">
      <div class="mb-3">
        <img v-if="form.profile_picture" class="profile-pic rounded-circle shadow mb-3" :src="form.profile_picture" alt="" />
        <img v-else class="profile-pic rounded-circle shadow mb-3" src="../../../Assets/profile.png" alt="" />
        <div class="mb-3">
          <label for="" class="form-label">Upload Profile Picture</label>
          <input
            id=""
            type="file"
            class="form-control"
            name=""
            placeholder=""
            aria-describedby="fileHelpId"
            @input="onChooseProfile"
          />
          <div id="fileHelpId" class="form-text">PNG, JPG</div>
        </div>
      </div>
      <div class="mb-3"> 
        <InputLabel for="surname" value="Surname" />

        <TextInput
          id="surname"
          v-model="form.surname"
          type="text"
          class="mt-1 block w-full"
          autocomplete="surname"
        />

        <InputError
          class="mt-2"
          :message="form.errors.surname"
        />
      </div>

      <div class="mb-3"> 
        <InputLabel for="first_name" value="First Name" />

        <TextInput
          id="first_name"
          v-model="form.first_name"
          type="text"
          class="mt-1 block w-full"
          autofocus
          autocomplete="first_name"
        />

        <InputError
          class="mt-2"
          :message="form.errors.first_name"
        />
      </div>

      <div class="mb-3"> 
        <InputLabel for="middle_name" value="Middle Name" />

        <TextInput
          id="middle_name"
          v-model="form.middle_name"
          type="text"
          class="mt-1 block w-full"
          autofocus
          autocomplete="middle_name"
        />

        <InputError
          class="mt-2"
          :message="form.errors.middle_name"
        />
      </div>
            
      <div class="mb-3"> 
        <InputLabel for="name_extension" value="Name Extension" />

        <TextInput
          id="name_extension"
          v-model="form.name_extension"
          type="text"
          class="mt-1 block w-full"
          autofocus
          autocomplete="name_extension"
        />
      </div>

      <!-- <div>
          <InputLabel for="name" value="Name" />

          <TextInput
            id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
            autocomplete="name"
          />

          <InputError class="mt-2" :message="form.errors.name" />
        </div> -->

      <div>
        <InputLabel for="username" value="Username" />

        <TextInput
          id="username" v-model="form.username" type="text" class="mt-1 block w-full" required
          autocomplete="username"
        />

        <InputError class="mt-2" :message="form.errors.username" />
      </div>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="text-sm mt-2 text-gray-800">
          Your email address is unverified.
          <Link
            :href="route('verification.send')" method="post" as="button"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Click here to re-send the verification email.
          </Link>
        </p>

        <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
          A new verification link has been sent to your email address.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton class="mt-3" :disabled="form.processing">Save</PrimaryButton>
        <p v-if="form.recentlySuccessful" class="text-success mt-2">
          Saved.
        </p>
      </div>
    </form>
  </section>
</template>

<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
})

const user = usePage().props.auth.user

const form = useForm({
  _method: 'patch',
  name: user.name,
  surname: user.surname,
  middle_name: user.middle_name,
  first_name: user.first_name,
  name_extension: user.name_extension,
  username: user.username,
  profile_picture: user.profile_pic,
})


const onChooseProfile = (e) => {
  form.profile_picture = e.target.files[0]
}
</script>