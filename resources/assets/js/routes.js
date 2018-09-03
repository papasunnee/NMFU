import DashboardComponent from './components/DashboardComponent'
import ProfileComponent from './components/ProfileComponent'
import MembersComponent from './components/MembersComponent'
import StudentsComponent from './components/StudentsComponent'

const routes = [
    { path: '/home', component: DashboardComponent },
    { path: '/profile', component: ProfileComponent },
    { path: '/members', component: MembersComponent },
    { path: '/students', component: StudentsComponent },
  ]

export default routes ;