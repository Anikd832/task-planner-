import {
  ApertureIcon,
  CopyIcon,
  LayoutDashboardIcon,
  LoginIcon,
  MoodHappyIcon,
  TypographyIcon,
  UserPlusIcon,
  FileDescriptionIcon,
  CalendarStatsIcon,
  BookIcon,
  UserIcon,
  UsersIcon,
  BuildingBankIcon,
  CalendarIcon,
  ListCheckIcon,
} from "vue-tabler-icons";

const sidebarItem = [
  { header: "Menu" },
  {
    title: "Dashboard",
    icon: LayoutDashboardIcon,
    to: "/app/dashboard",
  },
  {
    title: "Users",
    icon: UsersIcon,
    to: "users",
  },
  {
    title: "Class Routine",
    icon: FileDescriptionIcon,
    to: "routine",
  },

  { header: "Settings" },
  {
    title: "Subjects",
    icon: BookIcon,
    to: "subjects",
  },

];

export default sidebarItem;
