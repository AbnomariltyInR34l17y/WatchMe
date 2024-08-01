function checkVariableType(input, type) {
    switch (type) {
        case "string":
            return typeof input === "string";
        case "number":
            return typeof input === "number" && !isNaN(input);
        case "integer":
            return Number.isInteger(input);
        case "float":
            return typeof input === "number" && !Number.isInteger(input) && !isNaN(input);
        case "boolean":
            return typeof input === "boolean";
        case "array":
            return Array.isArray(input);
        default:
            return false; // Unsupported type
    }
}
