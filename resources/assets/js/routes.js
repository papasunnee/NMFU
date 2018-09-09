import DashboardComponent from './components/DashboardComponent'
import ProfileComponent from './components/ProfileComponent'
import MembersComponent from './components/MembersComponent'
import StudentsComponent from './components/StudentsComponent'
import DeveloperComponent from './components/DeveloperComponent'

const routes = [
    { path: '/home', component: DashboardComponent },
    { path: '/profile', component: ProfileComponent },
    { path: '/members', component: MembersComponent },
    { path: '/students', component: StudentsComponent },
    { path: '/developer', component: DeveloperComponent },
  ]

export default routes ;