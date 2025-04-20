export default function ResetObject(object) {
    Object.keys(object).forEach((key) => {
        object[key] = null;
    });
}
