function MenuAdmin(){
    return [
        {
            text: 'Dashboard',
            icon: 'mdi-monitor-dashboard',
            url: '/dashboard',
            role: ['admin', 'guru', 'pengawas']
        },
        {
            text: 'Guru',
            icon: 'mdi-account-tie',
            url: '#',
            role: ['admin']
        },
        {
            text: 'Jurnal',
            icon: 'mdi-clipboard-list-outline',
            url: '#',
            role: ['admin']
        },
        {
            text: 'Sekolah',
            icon: 'mdi-office-building-outline',
            url: '#',
            role: ['admin']
        },
        {
            text: 'Rombel',
            icon: 'mdi-google-classroom',
            url: '#',
            role: ['admin']
        },
        {
            text: 'Pengaturan',
            icon: 'mdi-cogs',
            url: '#',
            role: ['admin']
        },
    ]
}


export default {MenuAdmin}