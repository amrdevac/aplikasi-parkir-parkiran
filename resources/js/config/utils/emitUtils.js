export default class emitUtils {
    reloadIndexParking(isFire) {
        if (isFire) {
            return emitBy.$emit("fireToReloadIndexParking");
        }
        return "fireToReloadIndexParking";
    }

    verifyPasswordForUUIDParking(isFire, params = []) {
        if (isFire) {
            return emitBy.$emit("verifyPasswordForUUIDParking", params);
        }
        return "verifyPasswordForUUIDParking";
    }
}
