

 public static java.awt.Shape createPentacle(double sx, double sy, double radius,double theta) {
        final double arc = Math.PI / 5;
        final double rad = Math.sin(Math.PI / 10) / Math.sin(3 * Math.PI / 10);
        GeneralPath path = new GeneralPath();
        path.moveTo(1, 0);
        for (int idx = 0; idx < 5; idx++) {
            path.lineTo(rad * Math.cos((1 + 2 * idx) * arc),rad * Math.sin((1 + 2 * idx) * arc));
            path.lineTo(Math.cos(2 * (idx + 1) * arc),Math.sin(2 * (idx + 1) * arc));
        }
        path.closePath();
        AffineTransform atf = AffineTransform.getScaleInstance(radius, radius);
        atf.translate(sx / radius, sy / radius);
        atf.rotate(theta);
        return atf.createTransformedShape(path);
    }
