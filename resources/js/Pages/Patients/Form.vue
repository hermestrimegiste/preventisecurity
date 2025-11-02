<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { 
    UserIcon, 
    EnvelopeIcon, 
    PhoneIcon, 
    HomeIcon, 
    MapPinIcon, 
    CalendarIcon,
    IdentificationIcon,
    CakeIcon,
    FlagIcon,
    BriefcaseIcon
} from '@heroicons/vue/24/outline';
import Card from '@/Components/Card.vue';
import Button from '@/Components/Button.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import DatePicker from '@/Components/DatePicker.vue';

const props = defineProps({
    patient: {
        type: Object,
        default: () => ({
            id: null,
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            birth_date: '',
            gender: '',
            address: '',
            city: '',
            postal_code: '',
            country: 'France',
            emergency_contact_name: '',
            emergency_contact_phone: '',
            occupation: '',
            notes: '',
            blood_type: '',
            allergies: '',
            medications: '',
        }),
    },
    isEditing: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    first_name: props.patient.first_name || '',
    last_name: props.patient.last_name || '',
    email: props.patient.email || '',
    phone: props.patient.phone || '',
    birth_date: props.patient.birth_date || '',
    gender: props.patient.gender || '',
    address: props.patient.address || '',
    city: props.patient.city || '',
    postal_code: props.patient.postal_code || '',
    country: props.patient.country || 'France',
    emergency_contact_name: props.patient.emergency_contact_name || '',
    emergency_contact_phone: props.patient.emergency_contact_phone || '',
    occupation: props.patient.occupation || '',
    notes: props.patient.notes || '',
    blood_type: props.patient.blood_type || '',
    allergies: props.patient.allergies || '',
    medications: props.patient.medications || '',
});

const genderOptions = [
    { value: 'male', label: 'Homme' },
    { value: 'female', label: 'Femme' },
    { value: 'other', label: 'Autre' },
    { value: 'unknown', label: 'Non spécifié' },
];

const bloodTypeOptions = [
    { value: '', label: 'Non spécifié' },
    { value: 'A+', label: 'A+' },
    { value: 'A-', label: 'A-' },
    { value: 'B+', label: 'B+' },
    { value: 'B-', label: 'B-' },
    { value: 'AB+', label: 'AB+' },
    { value: 'AB-', label: 'AB-' },
    { value: 'O+', label: 'O+' },
    { value: 'O-', label: 'O-' },
];

const submit = () => {
    if (props.isEditing) {
        form.put(route('patients.update', props.patient.id), {
            preserveScroll: true,
            onSuccess: () => {
                // Gérer le succès (peut-être afficher une notification)
            },
        });
    } else {
        form.post(route('patients.store'), {
            preserveScroll: true,
            onSuccess: () => {
                // Rediriger vers la fiche du patient ou afficher un message
                form.reset();
            },
        });
    }
};

// Calculer l'âge à partir de la date de naissance
const age = computed(() => {
    if (!form.birth_date) return null;
    const birthDate = new Date(form.birth_date);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    
    return age;
});

// Formater la date pour l'affichage
const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <!-- Informations personnelles -->
        <Card>
            <template #header>
                <h3 class="text-lg font-medium text-gray-900">
                    <UserIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                    Informations personnelles
                </h3>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="first_name" value="Prénom *" />
                    <TextInput
                        id="first_name"
                        v-model="form.first_name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                    />
                    <InputError :message="form.errors.first_name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="last_name" value="Nom *" />
                    <TextInput
                        id="last_name"
                        v-model="form.last_name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                    />
                    <InputError :message="form.errors.last_name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="email" value="Email" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <EnvelopeIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="pl-10 block w-full"
                            placeholder="email@exemple.com"
                        />
                    </div>
                    <InputError :message="form.errors.email" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="phone" value="Téléphone" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <PhoneIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput
                            id="phone"
                            v-model="form.phone"
                            type="tel"
                            class="pl-10 block w-full"
                            placeholder="06 12 34 56 78"
                        />
                    </div>
                    <InputError :message="form.errors.phone" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="birth_date" value="Date de naissance" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <CakeIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <DatePicker
                            id="birth_date"
                            v-model="form.birth_date"
                            class="pl-10 block w-full"
                            :max="new Date().toISOString().split('T')[0]"
                        />
                    </div>
                    <div v-if="age !== null" class="mt-1 text-sm text-gray-500">
                        {{ age }} ans
                    </div>
                    <InputError :message="form.errors.birth_date" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="gender" value="Genre" />
                    <SelectInput
                        id="gender"
                        v-model="form.gender"
                        class="mt-1 block w-full"
                        :options="genderOptions"
                    />
                    <InputError :message="form.errors.gender" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="occupation" value="Profession" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <BriefcaseIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput
                            id="occupation"
                            v-model="form.occupation"
                            type="text"
                            class="pl-10 block w-full"
                            placeholder="Profession du patient"
                        />
                    </div>
                    <InputError :message="form.errors.occupation" class="mt-2" />
                </div>
            </div>
        </Card>

        <!-- Adresse -->
        <Card>
            <template #header>
                <h3 class="text-lg font-medium text-gray-900">
                    <MapPinIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                    Adresse
                </h3>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <InputLabel for="address" value="Adresse" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <HomeIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput
                            id="address"
                            v-model="form.address"
                            type="text"
                            class="pl-10 block w-full"
                            placeholder="123 rue de l'exemple"
                        />
                    </div>
                    <InputError :message="form.errors.address" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="postal_code" value="Code postal" />
                    <TextInput
                        id="postal_code"
                        v-model="form.postal_code"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="75000"
                    />
                    <InputError :message="form.errors.postal_code" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="city" value="Ville" />
                    <TextInput
                        id="city"
                        v-model="form.city"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Paris"
                    />
                    <InputError :message="form.errors.city" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="country" value="Pays" />
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <FlagIcon class="h-5 w-5 text-gray-400" />
                        </div>
                        <TextInput
                            id="country"
                            v-model="form.country"
                            type="text"
                            class="pl-10 block w-full"
                        />
                    </div>
                    <InputError :message="form.errors.country" class="mt-2" />
                </div>
            </div>
        </Card>

        <!-- Informations médicales -->
        <Card>
            <template #header>
                <h3 class="text-lg font-medium text-gray-900">
                    <IdentificationIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                    Informations médicales
                </h3>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="blood_type" value="Groupe sanguin" />
                    <SelectInput
                        id="blood_type"
                        v-model="form.blood_type"
                        class="mt-1 block w-full"
                        :options="bloodTypeOptions"
                    />
                    <InputError :message="form.errors.blood_type" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="allergies" value="Allergies connues" />
                    <TextareaInput
                        id="allergies"
                        v-model="form.allergies"
                        class="mt-1 block w-full"
                        rows="2"
                        placeholder="Liste des allergies séparées par des virgules"
                    />
                    <InputError :message="form.errors.allergies" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <InputLabel for="medications" value="Traitements en cours" />
                    <TextareaInput
                        id="medications"
                        v-model="form.medications"
                        class="mt-1 block w-full"
                        rows="2"
                        placeholder="Médicaments et traitements en cours"
                    />
                    <InputError :message="form.errors.medications" class="mt-2" />
                </div>
            </div>
        </Card>

        <!-- Contact d'urgence -->
        <Card>
            <template #header>
                <h3 class="text-lg font-medium text-gray-900">
                    <PhoneIcon class="h-5 w-5 inline-block mr-2 text-blue-500" />
                    Contact d'urgence
                </h3>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <InputLabel for="emergency_contact_name" value="Nom du contact" />
                    <TextInput
                        id="emergency_contact_name"
                        v-model="form.emergency_contact_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="Nom et prénom"
                    />
                    <InputError :message="form.errors.emergency_contact_name" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="emergency_contact_phone" value="Téléphone du contact" />
                    <TextInput
                        id="emergency_contact_phone"
                        v-model="form.emergency_contact_phone"
                        type="tel"
                        class="mt-1 block w-full"
                        placeholder="06 12 34 56 78"
                    />
                    <InputError :message="form.errors.emergency_contact_phone" class="mt-2" />
                </div>
            </div>
        </Card>

        <!-- Notes -->
        <Card>
            <template #header>
                <h3 class="text-lg font-medium text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Notes supplémentaires
                </h3>
            </template>

            <div>
                <TextareaInput
                    id="notes"
                    v-model="form.notes"
                    class="mt-1 block w-full"
                    rows="3"
                    placeholder="Notes supplémentaires sur le patient..."
                />
                <InputError :message="form.errors.notes" class="mt-2" />
            </div>
        </Card>

        <div class="flex justify-end space-x-3">
            <Link 
                :href="isEditing ? route('patients.show', patient.id) : route('patients.index')" 
                class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Annuler
            </Link>
            <Button 
                type="submit" 
                :class="{ 'opacity-25': form.processing }" 
                :disabled="form.processing"
            >
                {{ isEditing ? 'Mettre à jour' : 'Créer le patient' }}
            </Button>
        </div>
    </form>
</template>
