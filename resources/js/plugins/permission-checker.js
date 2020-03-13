export const MANAGE_BACKEND = "manage backend";

export function hasPerm(permissions, permissionToCheck) {

    if(permissions && permissions.filter( p => p.name == permissionToCheck).length > 0) {
        return true;
      } else {
        return false;
      }
}

